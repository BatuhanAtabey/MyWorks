/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package javaapplication8;
import java.util.Scanner;


/**
 *
 * @author MYO-OGRENCI
 */
public class JavaApplication8 {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        String harf ="";
        String kelime ="";
        int puan = 0;
        for(int i =0; i<8; i++){
        harf += (char) (int) (65+Math.random() *26);
        }
        System.out.println("Kulanacagın harfler= "+harf);
        System.out.print("bir kelime gir= ");
        Scanner oku = new Scanner(System.in);
        kelime = oku.next();
        
        for(int k=0; k<kelime.length(); k++){
            int yer = harf.indexOf(kelime.charAt(k));
           
        if (yer>-1) {
         puan +=1; 
         harf = harf.substring(0, yer) + harf.substring(yer+1);
         System.out.print(kelime.charAt(k)+"harfi var. Bravo!");
         
        }
        else
        {
            puan-=1;
            System.out.print(kelime.charAt(k)+" harfinin kullanamazsın. Ceza !\n");
                      
        }
        System.out.print("puanınız="+puan+"Kalan Harfler ="+harf);
        }
        
        
    }
    
}