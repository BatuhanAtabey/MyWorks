package javaapplication11;

public class JavaApplication11 {

    public enum Sehirler {
     Ankara("06","tarhana","Anıtkabir",10000,500000,500,900),
     Antalya("07","tantuni","falez",8000,33000,450,850),
     İstanbul("34","uykuluk","kız kulesi",15000,45000,150,300),
     Mardin("47","kaburga","mardin kalesi",1000,25000,800,1300),
     Trabzon("61","kuymak","sümela manastiri",2000,160000,1200,500),
     Samsun("55","terme pidesi","19 mayis limanı",4000,27000,400,30),
     İzmir("35","boyos","saat kulesi",11000,35000,20,400);
     
     private final String plaka;  
     private final String yemek;
     private final String sembol;
     private final int nufus;
     private final int gelir;
     private final int x;
     private final int y;
     
     private Sehirler(String plaka, String yemek, String sembol,int nufus,int gelir,int x,int y) {
         this.plaka = plaka;
         this.yemek = yemek;
         this.sembol =sembol;
         this.nufus = nufus;
         this.gelir = gelir;
         this.x =x;
         this.y =y;
     }
     public String plakaGetir(){ return this.plaka;}
      
     public String yemekIsmarla(){return this.yemek;}
     
     public String sembolSoyle(){return this.sembol;}
     
     public String barkod(){
          return (this.yemek.substring(0, 2)+this.plaka.substring(0, 2)+this.sembol.substring(0,2)).toUpperCase();
     }
     
     public int kisiBasiGelir() {return this.gelir/this.nufus;}
     
     public int mesafe (Sehirler sehir ){
       return (int) (Math.sqrt(Math.pow(this.x-sehir.x, 2)+Math.pow(this.y-sehir.y, 2)));  
         
     }
  }
    
    public static void main(String[] args) {
        Sehirler [] sehir = Sehirler.values();
        
        for(Sehirler s:sehir)
        System.out.println(s+"sehrinin plakası= "+s.plakaGetir()+", en meshur yemeği= "+s.yemekIsmarla()+"sembolü= "
                +s.sembolSoyle()+"barkodu= "+s.barkod()+" Kişi başı gelir= "+s.kisiBasiGelir());
         
        for(int k=0; k<Sehirler.values().length; k++ )
        for(int m=0; m<Sehirler.values().length; m++ )
            
        System.out.println(sehir[k]+ " ile"+sehir[m]+"arasındaki mesafe"+sehir[k].mesafe(sehir[m]));
    }
    
}
