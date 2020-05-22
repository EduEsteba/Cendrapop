/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Controladores;

import Controladores.exceptions.NonexistentEntityException;
import Entidades.ProductImages;
import java.io.Serializable;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import javax.persistence.criteria.CriteriaQuery;
import javax.persistence.criteria.Root;
import Entidades.Products;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Persistence;

/**
 *
 * @author Eduard
 */
public class ProductImagesJpaController implements Serializable {

    public ProductImagesJpaController() {
              this.emf = Persistence.createEntityManagerFactory("CendraPopPU");

    }
    private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(ProductImages productImages) {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            Products productId = productImages.getProductId();
            if (productId != null) {
                productId = em.getReference(productId.getClass(), productId.getId());
                productImages.setProductId(productId);
            }
            em.persist(productImages);
            if (productId != null) {
                productId.getProductImagesList().add(productImages);
                productId = em.merge(productId);
            }
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(ProductImages productImages) throws NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            ProductImages persistentProductImages = em.find(ProductImages.class, productImages.getId());
            Products productIdOld = persistentProductImages.getProductId();
            Products productIdNew = productImages.getProductId();
            if (productIdNew != null) {
                productIdNew = em.getReference(productIdNew.getClass(), productIdNew.getId());
                productImages.setProductId(productIdNew);
            }
            productImages = em.merge(productImages);
            if (productIdOld != null && !productIdOld.equals(productIdNew)) {
                productIdOld.getProductImagesList().remove(productImages);
                productIdOld = em.merge(productIdOld);
            }
            if (productIdNew != null && !productIdNew.equals(productIdOld)) {
                productIdNew.getProductImagesList().add(productImages);
                productIdNew = em.merge(productIdNew);
            }
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = productImages.getId();
                if (findProductImages(id) == null) {
                    throw new NonexistentEntityException("The productImages with id " + id + " no longer exists.");
                }
            }
            throw ex;
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void destroy(Integer id) throws NonexistentEntityException {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            ProductImages productImages;
            try {
                productImages = em.getReference(ProductImages.class, id);
                productImages.getId();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The productImages with id " + id + " no longer exists.", enfe);
            }
            Products productId = productImages.getProductId();
            if (productId != null) {
                productId.getProductImagesList().remove(productImages);
                productId = em.merge(productId);
            }
            em.remove(productImages);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<ProductImages> findProductImagesEntities() {
        return findProductImagesEntities(true, -1, -1);
    }

    public List<ProductImages> findProductImagesEntities(int maxResults, int firstResult) {
        return findProductImagesEntities(false, maxResults, firstResult);
    }

    private List<ProductImages> findProductImagesEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            CriteriaQuery cq = em.getCriteriaBuilder().createQuery();
            cq.select(cq.from(ProductImages.class));
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

    public ProductImages findProductImages(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(ProductImages.class, id);
        } finally {
            em.close();
        }
    }

    public int getProductImagesCount() {
        EntityManager em = getEntityManager();
        try {
            CriteriaQuery cq = em.getCriteriaBuilder().createQuery();
            Root<ProductImages> rt = cq.from(ProductImages.class);
            cq.select(em.getCriteriaBuilder().count(rt));
            Query q = em.createQuery(cq);
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
    
}
