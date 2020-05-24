/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Controladores;

import Controladores.exceptions.IllegalOrphanException;
import Controladores.exceptions.NonexistentEntityException;
import Entidades.Categories;
import java.io.Serializable;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import javax.persistence.criteria.CriteriaQuery;
import javax.persistence.criteria.Root;
import Entidades.Products;
import java.util.ArrayList;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Persistence;

/**
 *
 * @author Eduard
 */
public class CategoriesJpaController implements Serializable {

    public CategoriesJpaController() {
               this.emf = Persistence.createEntityManagerFactory("Persistencia");

    }
    private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(Categories categories) {
        if (categories.getProductsList() == null) {
            categories.setProductsList(new ArrayList<Products>());
        }
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            List<Products> attachedProductsList = new ArrayList<Products>();
            for (Products productsListProductsToAttach : categories.getProductsList()) {
                productsListProductsToAttach = em.getReference(productsListProductsToAttach.getClass(), productsListProductsToAttach.getId());
                attachedProductsList.add(productsListProductsToAttach);
            }
            categories.setProductsList(attachedProductsList);
            em.persist(categories);
            for (Products productsListProducts : categories.getProductsList()) {
                Categories oldCategoryIdOfProductsListProducts = productsListProducts.getCategoryId();
                productsListProducts.setCategoryId(categories);
                productsListProducts = em.merge(productsListProducts);
                if (oldCategoryIdOfProductsListProducts != null) {
                    oldCategoryIdOfProductsListProducts.getProductsList().remove(productsListProducts);
                    oldCategoryIdOfProductsListProducts = em.merge(oldCategoryIdOfProductsListProducts);
                }
            }
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(Categories categories) throws IllegalOrphanException, NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            Categories persistentCategories = em.find(Categories.class, categories.getId());
            List<Products> productsListOld = persistentCategories.getProductsList();
            List<Products> productsListNew = categories.getProductsList();
            List<String> illegalOrphanMessages = null;
            for (Products productsListOldProducts : productsListOld) {
                if (!productsListNew.contains(productsListOldProducts)) {
                    if (illegalOrphanMessages == null) {
                        illegalOrphanMessages = new ArrayList<String>();
                    }
                    illegalOrphanMessages.add("You must retain Products " + productsListOldProducts + " since its categoryId field is not nullable.");
                }
            }
            if (illegalOrphanMessages != null) {
                throw new IllegalOrphanException(illegalOrphanMessages);
            }
            List<Products> attachedProductsListNew = new ArrayList<Products>();
            for (Products productsListNewProductsToAttach : productsListNew) {
                productsListNewProductsToAttach = em.getReference(productsListNewProductsToAttach.getClass(), productsListNewProductsToAttach.getId());
                attachedProductsListNew.add(productsListNewProductsToAttach);
            }
            productsListNew = attachedProductsListNew;
            categories.setProductsList(productsListNew);
            categories = em.merge(categories);
            for (Products productsListNewProducts : productsListNew) {
                if (!productsListOld.contains(productsListNewProducts)) {
                    Categories oldCategoryIdOfProductsListNewProducts = productsListNewProducts.getCategoryId();
                    productsListNewProducts.setCategoryId(categories);
                    productsListNewProducts = em.merge(productsListNewProducts);
                    if (oldCategoryIdOfProductsListNewProducts != null && !oldCategoryIdOfProductsListNewProducts.equals(categories)) {
                        oldCategoryIdOfProductsListNewProducts.getProductsList().remove(productsListNewProducts);
                        oldCategoryIdOfProductsListNewProducts = em.merge(oldCategoryIdOfProductsListNewProducts);
                    }
                }
            }
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = categories.getId();
                if (findCategories(id) == null) {
                    throw new NonexistentEntityException("The categories with id " + id + " no longer exists.");
                }
            }
            throw ex;
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void destroy(Integer id) throws IllegalOrphanException, NonexistentEntityException {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            Categories categories;
            try {
                categories = em.getReference(Categories.class, id);
                categories.getId();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The categories with id " + id + " no longer exists.", enfe);
            }
            List<String> illegalOrphanMessages = null;
            List<Products> productsListOrphanCheck = categories.getProductsList();
            for (Products productsListOrphanCheckProducts : productsListOrphanCheck) {
                if (illegalOrphanMessages == null) {
                    illegalOrphanMessages = new ArrayList<String>();
                }
                illegalOrphanMessages.add("This Categories (" + categories + ") cannot be destroyed since the Products " + productsListOrphanCheckProducts + " in its productsList field has a non-nullable categoryId field.");
            }
            if (illegalOrphanMessages != null) {
                throw new IllegalOrphanException(illegalOrphanMessages);
            }
            em.remove(categories);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<Categories> findCategoriesEntities() {
        return findCategoriesEntities(true, -1, -1);
    }

    public List<Categories> findCategoriesEntities(int maxResults, int firstResult) {
        return findCategoriesEntities(false, maxResults, firstResult);
    }

    private List<Categories> findCategoriesEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            CriteriaQuery cq = em.getCriteriaBuilder().createQuery();
            cq.select(cq.from(Categories.class));
            Query q = em.createQuery(cq);
            if (!all) {
                q.setMaxResults(maxResults);
                q.setFirstResult(firstResult);
            }
            return q.getResultList();
        } finally {
            em.close();
        }
    }

    public Categories findCategories(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(Categories.class, id);
        } finally {
            em.close();
        }
    }

    public int getCategoriesCount() {
        EntityManager em = getEntityManager();
        try {
            CriteriaQuery cq = em.getCriteriaBuilder().createQuery();
            Root<Categories> rt = cq.from(Categories.class);
            cq.select(em.getCriteriaBuilder().count(rt));
            Query q = em.createQuery(cq);
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
    
}
