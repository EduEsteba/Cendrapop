/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Controladores;

import Controladores.exceptions.IllegalOrphanException;
import Controladores.exceptions.NonexistentEntityException;
import java.io.Serializable;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import javax.persistence.criteria.CriteriaQuery;
import javax.persistence.criteria.Root;
import Entidades.Categories;
import Entidades.Users;
import Entidades.ProductImages;
import java.util.ArrayList;
import java.util.List;
import Entidades.Messages;
import Entidades.Products;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Persistence;
//
import javax.persistence.Query;
import java.util.List;
import java.util.Scanner;

/**
 *
 * @author Eduard
 */
public class ProductsJpaController implements Serializable {
     DbController db = new DbController();
    boolean salir = false;
    Scanner teclado = new Scanner(System.in);
    
    public void opciones(){
        while(!salir) {
            System.out.println("-------- PRODUCTES -------");
            System.out.println("Opcions:");
            System.out.println("1 - Veure tots els productes");
            System.out.println("2 - Veure un producte.");
            System.out.println("0 - Tornar al menu principal...");
            System.out.println("-------------------------");
            System.out.print("Opción: ");
            int opcion = teclado.nextInt();
            decisiones(opcion);
        }
    }
    
     public void decisiones(int opcion){
        switch (opcion){
            case 1: getProductes(); break;
            case 2:
                System.out.println();
                System.out.print("Id del producte: ");
                int id = teclado.nextInt();
                getProductesid(id); break;
            case 0: salir = true; break;
        }
    }

    // GET: Per veure tots els productes
    public void getProductes(){
        try{
            Query q = db.executeQuery("select t from Products t");
            List<Products> productes = q.getResultList();
            if( productes.isEmpty()){
                System.out.println("Cap producte");
            }else{
                for(Products t : productes){
                System.out.println(t.getId()+" "+t.getTitle()+" "+t.getPrice()+"€");
            }
            }
            
        }catch (Exception e){
            System.out.println(e);
        }
    }

    // GET:Per veure un producte a partir de la id
    public void getProductesid(int id){
        try{
            Query q = db.executeQuery("select t from Products t where t.id = "+id);
            List<Products> productes = q.getResultList();
            if( productes.isEmpty()){
                System.out.println("Cap producte amb aquesta id");
            }else{
                for(Products t : productes){
                System.out.println(t.getId()+" "+t.getTitle()+" "+t.getPrice()+"€");
            }
            }
        }catch (Exception e){
            System.out.println(e);
        }
    }
    
    
    
    //
    public ProductsJpaController() {
             this.emf = Persistence.createEntityManagerFactory("Persistencia");

    }
    private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(Products products) {
        if (products.getProductImagesList() == null) {
            products.setProductImagesList(new ArrayList<ProductImages>());
        }
        if (products.getMessagesList() == null) {
            products.setMessagesList(new ArrayList<Messages>());
        }
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            Categories categoryId = products.getCategoryId();
            if (categoryId != null) {
                categoryId = em.getReference(categoryId.getClass(), categoryId.getId());
                products.setCategoryId(categoryId);
            }
            Users userId = products.getUserId();
            if (userId != null) {
                userId = em.getReference(userId.getClass(), userId.getId());
                products.setUserId(userId);
            }
            List<ProductImages> attachedProductImagesList = new ArrayList<ProductImages>();
            for (ProductImages productImagesListProductImagesToAttach : products.getProductImagesList()) {
                productImagesListProductImagesToAttach = em.getReference(productImagesListProductImagesToAttach.getClass(), productImagesListProductImagesToAttach.getId());
                attachedProductImagesList.add(productImagesListProductImagesToAttach);
            }
            products.setProductImagesList(attachedProductImagesList);
            List<Messages> attachedMessagesList = new ArrayList<Messages>();
            for (Messages messagesListMessagesToAttach : products.getMessagesList()) {
                messagesListMessagesToAttach = em.getReference(messagesListMessagesToAttach.getClass(), messagesListMessagesToAttach.getId());
                attachedMessagesList.add(messagesListMessagesToAttach);
            }
            products.setMessagesList(attachedMessagesList);
            em.persist(products);
            if (categoryId != null) {
                categoryId.getProductsList().add(products);
                categoryId = em.merge(categoryId);
            }
            if (userId != null) {
                userId.getProductsList().add(products);
                userId = em.merge(userId);
            }
            for (ProductImages productImagesListProductImages : products.getProductImagesList()) {
                Products oldProductIdOfProductImagesListProductImages = productImagesListProductImages.getProductId();
                productImagesListProductImages.setProductId(products);
                productImagesListProductImages = em.merge(productImagesListProductImages);
                if (oldProductIdOfProductImagesListProductImages != null) {
                    oldProductIdOfProductImagesListProductImages.getProductImagesList().remove(productImagesListProductImages);
                    oldProductIdOfProductImagesListProductImages = em.merge(oldProductIdOfProductImagesListProductImages);
                }
            }
            for (Messages messagesListMessages : products.getMessagesList()) {
                Products oldProductIdOfMessagesListMessages = messagesListMessages.getProductId();
                messagesListMessages.setProductId(products);
                messagesListMessages = em.merge(messagesListMessages);
                if (oldProductIdOfMessagesListMessages != null) {
                    oldProductIdOfMessagesListMessages.getMessagesList().remove(messagesListMessages);
                    oldProductIdOfMessagesListMessages = em.merge(oldProductIdOfMessagesListMessages);
                }
            }
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(Products products) throws IllegalOrphanException, NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            Products persistentProducts = em.find(Products.class, products.getId());
            Categories categoryIdOld = persistentProducts.getCategoryId();
            Categories categoryIdNew = products.getCategoryId();
            Users userIdOld = persistentProducts.getUserId();
            Users userIdNew = products.getUserId();
            List<ProductImages> productImagesListOld = persistentProducts.getProductImagesList();
            List<ProductImages> productImagesListNew = products.getProductImagesList();
            List<Messages> messagesListOld = persistentProducts.getMessagesList();
            List<Messages> messagesListNew = products.getMessagesList();
            List<String> illegalOrphanMessages = null;
            for (ProductImages productImagesListOldProductImages : productImagesListOld) {
                if (!productImagesListNew.contains(productImagesListOldProductImages)) {
                    if (illegalOrphanMessages == null) {
                        illegalOrphanMessages = new ArrayList<String>();
                    }
                    illegalOrphanMessages.add("You must retain ProductImages " + productImagesListOldProductImages + " since its productId field is not nullable.");
                }
            }
            for (Messages messagesListOldMessages : messagesListOld) {
                if (!messagesListNew.contains(messagesListOldMessages)) {
                    if (illegalOrphanMessages == null) {
                        illegalOrphanMessages = new ArrayList<String>();
                    }
                    illegalOrphanMessages.add("You must retain Messages " + messagesListOldMessages + " since its productId field is not nullable.");
                }
            }
            if (illegalOrphanMessages != null) {
                throw new IllegalOrphanException(illegalOrphanMessages);
            }
            if (categoryIdNew != null) {
                categoryIdNew = em.getReference(categoryIdNew.getClass(), categoryIdNew.getId());
                products.setCategoryId(categoryIdNew);
            }
            if (userIdNew != null) {
                userIdNew = em.getReference(userIdNew.getClass(), userIdNew.getId());
                products.setUserId(userIdNew);
            }
            List<ProductImages> attachedProductImagesListNew = new ArrayList<ProductImages>();
            for (ProductImages productImagesListNewProductImagesToAttach : productImagesListNew) {
                productImagesListNewProductImagesToAttach = em.getReference(productImagesListNewProductImagesToAttach.getClass(), productImagesListNewProductImagesToAttach.getId());
                attachedProductImagesListNew.add(productImagesListNewProductImagesToAttach);
            }
            productImagesListNew = attachedProductImagesListNew;
            products.setProductImagesList(productImagesListNew);
            List<Messages> attachedMessagesListNew = new ArrayList<Messages>();
            for (Messages messagesListNewMessagesToAttach : messagesListNew) {
                messagesListNewMessagesToAttach = em.getReference(messagesListNewMessagesToAttach.getClass(), messagesListNewMessagesToAttach.getId());
                attachedMessagesListNew.add(messagesListNewMessagesToAttach);
            }
            messagesListNew = attachedMessagesListNew;
            products.setMessagesList(messagesListNew);
            products = em.merge(products);
            if (categoryIdOld != null && !categoryIdOld.equals(categoryIdNew)) {
                categoryIdOld.getProductsList().remove(products);
                categoryIdOld = em.merge(categoryIdOld);
            }
            if (categoryIdNew != null && !categoryIdNew.equals(categoryIdOld)) {
                categoryIdNew.getProductsList().add(products);
                categoryIdNew = em.merge(categoryIdNew);
            }
            if (userIdOld != null && !userIdOld.equals(userIdNew)) {
                userIdOld.getProductsList().remove(products);
                userIdOld = em.merge(userIdOld);
            }
            if (userIdNew != null && !userIdNew.equals(userIdOld)) {
                userIdNew.getProductsList().add(products);
                userIdNew = em.merge(userIdNew);
            }
            for (ProductImages productImagesListNewProductImages : productImagesListNew) {
                if (!productImagesListOld.contains(productImagesListNewProductImages)) {
                    Products oldProductIdOfProductImagesListNewProductImages = productImagesListNewProductImages.getProductId();
                    productImagesListNewProductImages.setProductId(products);
                    productImagesListNewProductImages = em.merge(productImagesListNewProductImages);
                    if (oldProductIdOfProductImagesListNewProductImages != null && !oldProductIdOfProductImagesListNewProductImages.equals(products)) {
                        oldProductIdOfProductImagesListNewProductImages.getProductImagesList().remove(productImagesListNewProductImages);
                        oldProductIdOfProductImagesListNewProductImages = em.merge(oldProductIdOfProductImagesListNewProductImages);
                    }
                }
            }
            for (Messages messagesListNewMessages : messagesListNew) {
                if (!messagesListOld.contains(messagesListNewMessages)) {
                    Products oldProductIdOfMessagesListNewMessages = messagesListNewMessages.getProductId();
                    messagesListNewMessages.setProductId(products);
                    messagesListNewMessages = em.merge(messagesListNewMessages);
                    if (oldProductIdOfMessagesListNewMessages != null && !oldProductIdOfMessagesListNewMessages.equals(products)) {
                        oldProductIdOfMessagesListNewMessages.getMessagesList().remove(messagesListNewMessages);
                        oldProductIdOfMessagesListNewMessages = em.merge(oldProductIdOfMessagesListNewMessages);
                    }
                }
            }
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = products.getId();
                if (findProducts(id) == null) {
                    throw new NonexistentEntityException("The products with id " + id + " no longer exists.");
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
            Products products;
            try {
                products = em.getReference(Products.class, id);
                products.getId();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The products with id " + id + " no longer exists.", enfe);
            }
            List<String> illegalOrphanMessages = null;
            List<ProductImages> productImagesListOrphanCheck = products.getProductImagesList();
            for (ProductImages productImagesListOrphanCheckProductImages : productImagesListOrphanCheck) {
                if (illegalOrphanMessages == null) {
                    illegalOrphanMessages = new ArrayList<String>();
                }
                illegalOrphanMessages.add("This Products (" + products + ") cannot be destroyed since the ProductImages " + productImagesListOrphanCheckProductImages + " in its productImagesList field has a non-nullable productId field.");
            }
            List<Messages> messagesListOrphanCheck = products.getMessagesList();
            for (Messages messagesListOrphanCheckMessages : messagesListOrphanCheck) {
                if (illegalOrphanMessages == null) {
                    illegalOrphanMessages = new ArrayList<String>();
                }
                illegalOrphanMessages.add("This Products (" + products + ") cannot be destroyed since the Messages " + messagesListOrphanCheckMessages + " in its messagesList field has a non-nullable productId field.");
            }
            if (illegalOrphanMessages != null) {
                throw new IllegalOrphanException(illegalOrphanMessages);
            }
            Categories categoryId = products.getCategoryId();
            if (categoryId != null) {
                categoryId.getProductsList().remove(products);
                categoryId = em.merge(categoryId);
            }
            Users userId = products.getUserId();
            if (userId != null) {
                userId.getProductsList().remove(products);
                userId = em.merge(userId);
            }
            em.remove(products);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<Products> findProductsEntities() {
        return findProductsEntities(true, -1, -1);
    }

    public List<Products> findProductsEntities(int maxResults, int firstResult) {
        return findProductsEntities(false, maxResults, firstResult);
    }

    private List<Products> findProductsEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            CriteriaQuery cq = em.getCriteriaBuilder().createQuery();
            cq.select(cq.from(Products.class));
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

    public Products findProducts(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(Products.class, id);
        } finally {
            em.close();
        }
    }

    public int getProductsCount() {
        EntityManager em = getEntityManager();
        try {
            CriteriaQuery cq = em.getCriteriaBuilder().createQuery();
            Root<Products> rt = cq.from(Products.class);
            cq.select(em.getCriteriaBuilder().count(rt));
            Query q = em.createQuery(cq);
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
    
}
