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
import Entidades.Messages;
import java.util.ArrayList;
import java.util.List;
import Entidades.Products;
import Entidades.Users;
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
public class UsersJpaController implements Serializable {
    
    DbController db = new DbController();
    boolean salir = false;
    Scanner teclado = new Scanner(System.in);
    
   // Llista de opciones:
    public void opciones(){
        while(!salir) {
            System.out.println("-------- USUARIS -------");
            System.out.println("Opciones:");
            System.out.println("1 - Veure tots els usuaris.");
            System.out.println("2 - Veure un usuari.");
            System.out.println("0 - Tornar al menu principal...");
            System.out.println("-------------------------");
            System.out.print("Opció: ");
            int opcion = teclado.nextInt();
            decisiones(opcion);
        }
    }
    
    // Llista de decisiones:
    public void decisiones(int opcion){
        switch (opcion){
            case 1: getUsers(); break;
            case 2:
                System.out.println();
                System.out.print("Id del usuari: ");
                int id = teclado.nextInt();
                getUser(id); break;
            case 0: salir = true; break;
        }
    }
    
     // GET: Per veure tots els usuaris
     public void getUsers(){
        try{
            Query q = db.executeQuery("select u from Users u");
            List<Users> usuarios = q.getResultList();
            for(Users t : usuarios){
                System.out.println(t.getId()+" "+t.getName()+" "+t.getRole());
            }
        }catch (Exception e){
            System.out.println(e);
        }
    }
    
    // GET:Per veure un usuari a partir de la id
     public void getUser(int id){
        try{
            Query q = db.executeQuery("select u from Users u where u.id = "+id);
            List<Users> usuarios = q.getResultList();
            if(usuarios.isEmpty()){
                System.out.println("Cap usuari amb aquesta ID");

            }else{
                 for(Users t : usuarios){
                System.out.println(t.getId()+" "+t.getName()+" "+t.getRole());
            }
            }
           
        }catch (Exception e){
            System.out.println(e);
        }
    }
    
    
    //Coses creades automaticament

    public UsersJpaController() {
       this.emf = Persistence.createEntityManagerFactory("Persistencia");
    }
    private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(Users users) {
        if (users.getMessagesList() == null) {
            users.setMessagesList(new ArrayList<Messages>());
        }
        if (users.getProductsList() == null) {
            users.setProductsList(new ArrayList<Products>());
        }
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            List<Messages> attachedMessagesList = new ArrayList<Messages>();
            for (Messages messagesListMessagesToAttach : users.getMessagesList()) {
                messagesListMessagesToAttach = em.getReference(messagesListMessagesToAttach.getClass(), messagesListMessagesToAttach.getId());
                attachedMessagesList.add(messagesListMessagesToAttach);
            }
            users.setMessagesList(attachedMessagesList);
            List<Products> attachedProductsList = new ArrayList<Products>();
            for (Products productsListProductsToAttach : users.getProductsList()) {
                productsListProductsToAttach = em.getReference(productsListProductsToAttach.getClass(), productsListProductsToAttach.getId());
                attachedProductsList.add(productsListProductsToAttach);
            }
            users.setProductsList(attachedProductsList);
            em.persist(users);
            for (Messages messagesListMessages : users.getMessagesList()) {
                Users oldUserIdOfMessagesListMessages = messagesListMessages.getUserId();
                messagesListMessages.setUserId(users);
                messagesListMessages = em.merge(messagesListMessages);
                if (oldUserIdOfMessagesListMessages != null) {
                    oldUserIdOfMessagesListMessages.getMessagesList().remove(messagesListMessages);
                    oldUserIdOfMessagesListMessages = em.merge(oldUserIdOfMessagesListMessages);
                }
            }
            for (Products productsListProducts : users.getProductsList()) {
                Users oldUserIdOfProductsListProducts = productsListProducts.getUserId();
                productsListProducts.setUserId(users);
                productsListProducts = em.merge(productsListProducts);
                if (oldUserIdOfProductsListProducts != null) {
                    oldUserIdOfProductsListProducts.getProductsList().remove(productsListProducts);
                    oldUserIdOfProductsListProducts = em.merge(oldUserIdOfProductsListProducts);
                }
            }
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(Users users) throws IllegalOrphanException, NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            Users persistentUsers = em.find(Users.class, users.getId());
            List<Messages> messagesListOld = persistentUsers.getMessagesList();
            List<Messages> messagesListNew = users.getMessagesList();
            List<Products> productsListOld = persistentUsers.getProductsList();
            List<Products> productsListNew = users.getProductsList();
            List<String> illegalOrphanMessages = null;
            for (Messages messagesListOldMessages : messagesListOld) {
                if (!messagesListNew.contains(messagesListOldMessages)) {
                    if (illegalOrphanMessages == null) {
                        illegalOrphanMessages = new ArrayList<String>();
                    }
                    illegalOrphanMessages.add("You must retain Messages " + messagesListOldMessages + " since its userId field is not nullable.");
                }
            }
            for (Products productsListOldProducts : productsListOld) {
                if (!productsListNew.contains(productsListOldProducts)) {
                    if (illegalOrphanMessages == null) {
                        illegalOrphanMessages = new ArrayList<String>();
                    }
                    illegalOrphanMessages.add("You must retain Products " + productsListOldProducts + " since its userId field is not nullable.");
                }
            }
            if (illegalOrphanMessages != null) {
                throw new IllegalOrphanException(illegalOrphanMessages);
            }
            List<Messages> attachedMessagesListNew = new ArrayList<Messages>();
            for (Messages messagesListNewMessagesToAttach : messagesListNew) {
                messagesListNewMessagesToAttach = em.getReference(messagesListNewMessagesToAttach.getClass(), messagesListNewMessagesToAttach.getId());
                attachedMessagesListNew.add(messagesListNewMessagesToAttach);
            }
            messagesListNew = attachedMessagesListNew;
            users.setMessagesList(messagesListNew);
            List<Products> attachedProductsListNew = new ArrayList<Products>();
            for (Products productsListNewProductsToAttach : productsListNew) {
                productsListNewProductsToAttach = em.getReference(productsListNewProductsToAttach.getClass(), productsListNewProductsToAttach.getId());
                attachedProductsListNew.add(productsListNewProductsToAttach);
            }
            productsListNew = attachedProductsListNew;
            users.setProductsList(productsListNew);
            users = em.merge(users);
            for (Messages messagesListNewMessages : messagesListNew) {
                if (!messagesListOld.contains(messagesListNewMessages)) {
                    Users oldUserIdOfMessagesListNewMessages = messagesListNewMessages.getUserId();
                    messagesListNewMessages.setUserId(users);
                    messagesListNewMessages = em.merge(messagesListNewMessages);
                    if (oldUserIdOfMessagesListNewMessages != null && !oldUserIdOfMessagesListNewMessages.equals(users)) {
                        oldUserIdOfMessagesListNewMessages.getMessagesList().remove(messagesListNewMessages);
                        oldUserIdOfMessagesListNewMessages = em.merge(oldUserIdOfMessagesListNewMessages);
                    }
                }
            }
            for (Products productsListNewProducts : productsListNew) {
                if (!productsListOld.contains(productsListNewProducts)) {
                    Users oldUserIdOfProductsListNewProducts = productsListNewProducts.getUserId();
                    productsListNewProducts.setUserId(users);
                    productsListNewProducts = em.merge(productsListNewProducts);
                    if (oldUserIdOfProductsListNewProducts != null && !oldUserIdOfProductsListNewProducts.equals(users)) {
                        oldUserIdOfProductsListNewProducts.getProductsList().remove(productsListNewProducts);
                        oldUserIdOfProductsListNewProducts = em.merge(oldUserIdOfProductsListNewProducts);
                    }
                }
            }
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = users.getId();
                if (findUsers(id) == null) {
                    throw new NonexistentEntityException("The users with id " + id + " no longer exists.");
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
            Users users;
            try {
                users = em.getReference(Users.class, id);
                users.getId();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The users with id " + id + " no longer exists.", enfe);
            }
            List<String> illegalOrphanMessages = null;
            List<Messages> messagesListOrphanCheck = users.getMessagesList();
            for (Messages messagesListOrphanCheckMessages : messagesListOrphanCheck) {
                if (illegalOrphanMessages == null) {
                    illegalOrphanMessages = new ArrayList<String>();
                }
                illegalOrphanMessages.add("This Users (" + users + ") cannot be destroyed since the Messages " + messagesListOrphanCheckMessages + " in its messagesList field has a non-nullable userId field.");
            }
            List<Products> productsListOrphanCheck = users.getProductsList();
            for (Products productsListOrphanCheckProducts : productsListOrphanCheck) {
                if (illegalOrphanMessages == null) {
                    illegalOrphanMessages = new ArrayList<String>();
                }
                illegalOrphanMessages.add("This Users (" + users + ") cannot be destroyed since the Products " + productsListOrphanCheckProducts + " in its productsList field has a non-nullable userId field.");
            }
            if (illegalOrphanMessages != null) {
                throw new IllegalOrphanException(illegalOrphanMessages);
            }
            em.remove(users);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<Users> findUsersEntities() {
        return findUsersEntities(true, -1, -1);
    }

    public List<Users> findUsersEntities(int maxResults, int firstResult) {
        return findUsersEntities(false, maxResults, firstResult);
    }

    private List<Users> findUsersEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            CriteriaQuery cq = em.getCriteriaBuilder().createQuery();
            cq.select(cq.from(Users.class));
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

    public Users findUsers(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(Users.class, id);
        } finally {
            em.close();
        }
    }

    public int getUsersCount() {
        EntityManager em = getEntityManager();
        try {
            CriteriaQuery cq = em.getCriteriaBuilder().createQuery();
            Root<Users> rt = cq.from(Users.class);
            cq.select(em.getCriteriaBuilder().count(rt));
            Query q = em.createQuery(cq);
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
    
}
