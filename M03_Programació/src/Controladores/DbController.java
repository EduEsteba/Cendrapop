/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Controladores;

import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Persistence;
import javax.persistence.Query;

/**
 *
 * @author Eduard
 */
public class DbController {
    private static EntityManagerFactory emf = Persistence.createEntityManagerFactory("Persistencia");
    private static EntityManager manager = emf.createEntityManager();
    
    
     public Query executeQuery(String sql){
        Query query = null;
        try{
            query = manager.createQuery(sql);
            return query;
        }catch (Exception e){
            System.out.println(e);
        }
        return query;
    }
}
