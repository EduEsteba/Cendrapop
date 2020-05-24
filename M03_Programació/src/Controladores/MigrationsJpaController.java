/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Controladores;

import Controladores.exceptions.NonexistentEntityException;
import Entidades.Migrations;
import java.io.Serializable;
import java.util.List;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import javax.persistence.Persistence;
import javax.persistence.criteria.CriteriaQuery;
import javax.persistence.criteria.Root;

/**
 *
 * @author Eduard
 */
public class MigrationsJpaController implements Serializable {

    public MigrationsJpaController() {
               this.emf = Persistence.createEntityManagerFactory("Persistencia");

    }
    private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(Migrations migrations) {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            em.persist(migrations);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(Migrations migrations) throws NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            migrations = em.merge(migrations);
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = migrations.getId();
                if (findMigrations(id) == null) {
                    throw new NonexistentEntityException("The migrations with id " + id + " no longer exists.");
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
            Migrations migrations;
            try {
                migrations = em.getReference(Migrations.class, id);
                migrations.getId();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The migrations with id " + id + " no longer exists.", enfe);
            }
            em.remove(migrations);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<Migrations> findMigrationsEntities() {
        return findMigrationsEntities(true, -1, -1);
    }

    public List<Migrations> findMigrationsEntities(int maxResults, int firstResult) {
        return findMigrationsEntities(false, maxResults, firstResult);
    }

    private List<Migrations> findMigrationsEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            CriteriaQuery cq = em.getCriteriaBuilder().createQuery();
            cq.select(cq.from(Migrations.class));
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

    public Migrations findMigrations(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(Migrations.class, id);
        } finally {
            em.close();
        }
    }

    public int getMigrationsCount() {
        EntityManager em = getEntityManager();
        try {
            CriteriaQuery cq = em.getCriteriaBuilder().createQuery();
            Root<Migrations> rt = cq.from(Migrations.class);
            cq.select(em.getCriteriaBuilder().count(rt));
            Query q = em.createQuery(cq);
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
    
}
