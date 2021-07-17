/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package pkg1.pkg03.pkg2019;

import java.util.ArrayList;

/**
 *
 * @author MYO-OGRENCI
 */
public class Main {


    public static void main(String[] args) {
        ArrayList<String>sinif= new ArrayList<String>();
        sinif.add("Mahmut");
        sinif.add("Mehmet");
        sinif.add("Okan");
        sinif.add("Emre");
        sinif.add("Deniz");
        
        
        
        sinif.add(2, "Oğuzhan");
        sinif.sort(null);
        sinif.remove("MEHMET");
        
        for (int k = 0; k < sinif.size(); k++) {
            
            String gecici="";
            for (int u = 0; u < sinif.get(k).length(); u++) {
                
                gecici+=sinif.get(k).substring(sinif.get(k).length()-u-1, sinif.get(k).length()-u);
                
            }          
            if (sinif.get(k).length()>5)sinif.set(k,sinif.get(k).substring(5)+"*****");
            

            
            System.out.println(sinif.get(k));
        }
        
        

    }
    
}
