/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package pkg8.mart;

import java.util.Scanner;


public class MART {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        int[] notlar={0,0,0,0,0};
        float top=0;
        Scanner okuma = new Scanner (System.in);
        System.out.print("NOT GİRİNİZ");
        System.out.print("----------------------");
        
        
        for (int x = 0; x < notlar.length; x++) {
            System.out.print(x+1+".notunuzu giriniz");
            notlar[x]=okuma.nextInt();
            top+=notlar[x];
        }
        System.out.println("Ortalamanız"+top/5);

        
   }
    
    
}
