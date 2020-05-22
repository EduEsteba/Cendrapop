/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Controladores;

import Controladores.exceptions.NonexistentEntityException;
import Entidades.Messages;
import java.io.Serializable;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import javax.persistence.criteria.CriteriaQuery;
import javax.persistence.criteria.Root;
import Entidades.Products;
import Entidades.Users;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Persistence;




/**
 *
 * @author Eduard
 */
public class MessagesJpaController implements Serializable {
    
    
   
    public MessagesJpaController() {
               this.emf = Persistence.createEntityManagerFactory("Persistencia");

    }
    private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(Messages messages) {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            Products productId = messages.getProductId();
            if (productId != null) {
                productId = em.getReference(productId.getClass(), productId.getId());
                messages.setProductId(productId);
            }
            Users userId = messages.getUserId();
            if (userId != null) {
                userId = em.getReference(userId.getClass(), userId.getId());
                messages.setUserId(userId);
            }
            em.persist(messages);
            if (productId != null) {
                productId.getMessagesList().add(messages);
                productId = em.merge(productId);
            }
            if (userId != null) {
                userId.getMessagesList().add(messages);
                userId = em.merge(userId);
            }
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(Messages messages) throws NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            Messages persistentMessages = em.find(Messages.class, messages.getId());
            Products productIdOld = persistentMessages.getProductId();
            Products productIdNew = messages.getProductId();
            Users userIdOld = persistentMessages.getUserId();
            Users userIdNew = messages.getUserId();
            if (productIdNew != null) {
                productIdNew = em.getReference(productIdNew.getClass(), productIdNew.getId());
                messages.setProductId(productIdNew);
            }
            if (userIdNew != null) {
                userIdNew = em.getReference(userIdNew.getClass(), userIdNew.getId());
                messages.setUserId(userIdNew);
            }
            messages = em.merge(messages);
            if (productIdOld != null && !productIdOld.equals(productIdNew)) {
                productIdOld.getMessagesList().remove(messages);
                productIdOld = em.merge(productIdOld);
            }
            if (productIdNew != null && !productIdNew.equals(productIdOld)) {
                productIdNew.getMessagesList().add(messages);
                productIdNew = em.merge(productIdNew);
            }
            if (userIdOld != null && !userIdOld.equals(userIdNew)) {
                userIdOld.getMessagesList().remove(messages);
                userIdOld = em.merge(userIdOld);
            }
            if (userIdNew != null && !userIdNew.equals(userIdOld)) {
                userIdNew.getMessagesList().add(messages);
                userIdNew = em.merge(userIdNew);
            }
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = messages.getId();
                if (findMessages(id) == null) {
                    throw new NonexistentEntityException("The messages with id " + id + " no longer exists.");
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
            Messages messages;
            try {
                messages = em.getReference(Messages.class, id);
                messages.getId();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The messages with id " + id + " no longer exists.", enfe);
            }
            Products productId = messages.getProductId();
            if (productId != null) {
                productId.getMessagesList().remove(messages);
                productId = em.merge(productId);
            }
            Users userId = messages.getUserId();
            if (userId != null) {
                userId.getMessagesList().remove(messages);
                userId = em.merge(userId);
            }
            em.remove(messages);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<Messages> findMessagesEntities() {
        return findMessagesEntities(true, -1, -1);
    }

    public List<Messages> findMessagesEntities(int maxResults, int firstResult) {
        return findMessagesEntities(false, maxResults, firstResult);
    }

    private List<Messages> findMessagesEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            CriteriaQuery cq = em.getCriteriaBuilder().createQuery();
            cq.select(cq.from(Messages.class));
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

    public Messages findMessages(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(Messages.class, id);
        } finally {
            em.close();
        }
    }

    public int getMessagesCount() {
        EntityManager em = getEntityManager();
        try {
            CriteriaQuery cq = em.getCriteriaBuilder().createQuery();
            Root<Messages> rt = cq.from(Messages.class);
            cq.select(em.getCriteriaBuilder().count(rt));
            Query q = em.createQuery(cq);
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
    
}
