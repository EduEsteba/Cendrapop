
package cendrapop;

import Controladores.*;
import java.util.Scanner;

/**
 *
 * @author Eduard
 */
public class CendraPop {

    /**
     * @param args the command line arguments
     */
    
    //Diferents controladors
    static UsersJpaController UsersJpaController = new UsersJpaController();
    static ProductsJpaController ProductsJpaController = new ProductsJpaController();
    static MessagesJpaController MessagesJpaController = new MessagesJpaController();
    //Boolea per saber si el programa a acabat
    static boolean salir = false;

    
    public static void main(String[] args) {
       Scanner teclado = new Scanner(System.in);
        while(!salir){
            opciones();
            int opcion = teclado.nextInt();
            decisiones(opcion);
        }
    }
    
     public static void opciones(){
        System.out.println("Opcions: ");
        System.out.println("1 - Usuaris");
        System.out.println("2 - Productes");
        System.out.println("0 - Sortir");
        System.out.print("Opció: ");
    }

    public static void decisiones(int opcion){
        switch (opcion){
            case 1: UsersJpaController.opciones(); break;
            case 2: ProductsJpaController.opciones(); break;
            case 0: salir = true; break;
        }
    }
    
}
