
package pkg15.mart.pkg2019;

import java.util.Scanner;

public class MART2019 {

    public static void main(String[] args) {
        String harfler="";
        String kelime="";
        int puan=0;
        for (int k = 0; k < 8; k++) {
            harfler+=(char) (int) (65+Math.random()*26);
            
            System.out.println("Kullanacağınız harfler="+harfler);
            
            Scanner oku= new Scanner(System.in);
            System.out.print("Kelimenizi giriniz =");
            kelime=oku.next();
            
            for (int m = 0; m < kelime.length(); m++) {
                 if (harfler.indexOf(kelime.charAt(m))>-1) {
                     puan+=1;
                     System.out.println(kelime.charAt(m)+"Harfi var BRAVO!");
                    
                }
                 else
                 {
                     puan-=1;
                     System.out.println(kelime.charAt(m)+"Harfi yok ÜZGÜNÜM!");
                 }
                     
                    
                }
            System.out.println("Hakkınız bitmiştir toplam puanınız"+puan);
           
                 

                
            }
            
            
        }
        
    }
    

