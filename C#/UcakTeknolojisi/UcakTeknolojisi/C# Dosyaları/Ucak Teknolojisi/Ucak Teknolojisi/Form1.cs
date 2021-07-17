using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.IO;
using iTextSharp.text;
using iTextSharp.text.pdf;
using System.Windows.Forms;

namespace Ucak_Teknolojisi
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }
        DataTable tbl = new DataTable();
        private void Form1_Load(object sender, EventArgs e)
        {
            //DataGridViewButtonColumn btn = new DataGridViewButtonColumn();
            tbl.Columns.Add("Ders İsmi");
            tbl.Columns.Add("Donem");
            tbl.Columns.Add("Kredi");
            tbl.Columns.Add("Vize");
            tbl.Columns.Add("Final");
            tbl.Columns.Add("Not Ortalaması");
            tbl.Columns.Add("Harf Notu");
            tbl.Columns.Add("Kat Sayisi");
            tbl.Columns.Add("Ano & Gano Etkisi");
            tbl.Columns.Add("Ano & Gano Etkisi 2");
            dataGridView1.EnableHeadersVisualStyles = false;
            dataGridView1.ColumnHeadersDefaultCellStyle.ForeColor = Color.Blue;
            groupBox2.Hide();
        }

        private string[] donem1Dersler = { "Atatürk İlkeleri ve İnkılap Tarihi-I", "İngilizce-I"
        ,"Sivil Havacılığa Giriş","Teknik Resim","Temel Fizik","Temel Matematik","Türk Dili-I",
        "Uçak ve Uçuş Bilgisi"};
        private string[] donem2Dersler = { "Atatürk İlkeleri ve İnkılap Tarihi-II" ,"Havacılık Mevzuatı ve Kuralları",
        "Havacılıkta İmalat, Malzeme ve Donanım","İngilizce-II","Temel Aerodinamik","Temel Bilgi Teknolojileri",
        "Temel Elektrik-Elektronik","Türk Dili-II"};
        private string[] donem3Dersler = { "Dijital Teknikler ve Elektronik Alet Sistemleri","Gaz Türbinli Motorlar",
        "Mesleki İngilizce-I","Pistonlu Motorlar","Seçmeli Ders-I","Staj Uygulaması","Uçak Bakım ve Onarım-I",
        "Uçak Yapı ve Sistemleri-I"};
        private string[] donem4Dersler = { "Havacılıkta İnsan Faktörleri" , "Mesleki İngilizce-II", "Pervane",
        "Seçmeli Ders-II","Uçak Bakım ve Onarım-II","Uçak ve Motor Göstergeleri","Uçak Yapı ve Sistemleri-II","Çevre Koruma, İş Sağlığı ve Güvenliği"};
        private double[] krediler = { 2, 6, 2, 2, 2, 3, 2, 2,/*2.Dönem*/2, 2, 3, 6, 3, 2, 3, 2 /*3.Dönem*/, 2, 2, 4, 2, 2, 2, 3, 3/*4.Dönem*/, 2, 4, 2, 2, 3, 3, 3, 3 };

 
        private void donemEkle(int donemsayisi)
        {
            int sayac = 0;
            if (donemsayisi == 1) sayac = 8;
            if (donemsayisi == 2) sayac = 16;
            if (donemsayisi == 3) sayac = 24;
            if (donemsayisi == 4) sayac = 32;
            donemsayisi = 1;
            for (int d = 0; d < sayac; d++)
            {
                if (d % 8 == 0 && d != 0)
                {
                    donemsayisi++;
                }
                tbl.Rows[d][1] = donemsayisi;
            }//tbl.Rows[3][1] = a;
        }
        private void dersEkle(string[] derslistesi)
        {
            int derssayisi = derslistesi.Length;
            for (int i = 0; i < derssayisi; i++)
            {
                tbl.Rows.Add(derslistesi[i]);
            }
        }
        private void kredileriEkle()
        {
            int donemsayisi = int.Parse(comboBox1.Text);
            int sayac = 0;
            if (donemsayisi == 1) sayac = 8;
            if (donemsayisi == 2) sayac = 16;
            if (donemsayisi == 3) sayac = 24;
            if (donemsayisi == 4) sayac = 32;

            for (int i = 0; i < sayac; i++)
            {
                tbl.Rows[i][2] = krediler[i];
            }

        }
        private void BilgileriEkle()
        {
            int donemsayisi = int.Parse(comboBox1.Text);
            if (donemsayisi == 1)
            {

                dersEkle(donem1Dersler);
                donemEkle(donemsayisi);

            }
            if (donemsayisi == 2)
            {
                dersEkle(donem1Dersler);
                dersEkle(donem2Dersler);
                donemEkle(donemsayisi);

            }
            if (donemsayisi == 3)
            {
                dersEkle(donem1Dersler);
                dersEkle(donem2Dersler);
                dersEkle(donem3Dersler);
                donemEkle(donemsayisi);

            }
            if (donemsayisi == 4)
            {
                dersEkle(donem1Dersler);
                dersEkle(donem2Dersler);
                dersEkle(donem3Dersler);
                dersEkle(donem4Dersler);
                donemEkle(donemsayisi);

            }
        }
        private void button1_Click(object sender, EventArgs e)
        {
            int donemsayisi = int.Parse(comboBox1.Text);
            tbl.Clear();

            BilgileriEkle();
            kredileriEkle();
            dataGridView1.DataSource = tbl;
            
         

        }
        double NotOrt = 0;
        public double NotOrtalamaHesapla(double vize, double final)
        {
            double NotOrt = 0;
            NotOrt = 0;
            NotOrt = (vize * 0.4) + (final * 0.6);
            return NotOrt;
        }
        private void harfNotlarıEkle(int sayac)
        {
            double katsayisi = 0;
            string harfNotu = "";
            for (int i = 0; i < sayac; i++)
            {

                
                double notortalamasi= Convert.ToDouble(tbl.Rows[i][5]);
                if (notortalamasi <= 100 && notortalamasi >= 90) { harfNotu = "AA"; katsayisi = 4.00; }
                if (notortalamasi <= 89 && notortalamasi >= 85) { harfNotu = "BA"; katsayisi = 3.50; }
                if (notortalamasi <= 84 && notortalamasi >= 75) { harfNotu = "BB"; katsayisi = 3.00; }
                if (notortalamasi <= 74 && notortalamasi >= 65) { harfNotu = "CB"; katsayisi = 2.50; }
                if (notortalamasi <= 64 && notortalamasi >= 60) { harfNotu = "CC"; katsayisi = 2.00; }
                if (notortalamasi <= 59 && notortalamasi >= 50) { harfNotu = "DC"; katsayisi = 1.50; }
                if (notortalamasi <= 49 && notortalamasi >= 45) { harfNotu = "DD"; katsayisi = 1.00; }
                if (notortalamasi <= 44 && notortalamasi >= 40) { harfNotu = "FD"; katsayisi = 0.50; }
                if (notortalamasi <= 39 && notortalamasi >= 00) { harfNotu = "FF"; katsayisi = 0.00; }
                tbl.Rows[i][6] = harfNotu;
                tbl.Rows[i][7] = katsayisi;
            }
        }
        private void basariPuanEtkisi(int sayac)
        {
            for(int i = 0; i < sayac; i++)
            {
                // 2 *7 
                double kredidegeri = Convert.ToDouble(tbl.Rows[i][2]);
                double katsayisi = Convert.ToDouble(tbl.Rows[i][7]);
                double basaripuani = 0.00;
                basaripuani = kredidegeri * katsayisi;
                tbl.Rows[i][8] = basaripuani;
            }
        }
        private void GanohesapLa(int sayac)
        {
            double anodegerleri1 = 0.0;
            double anodegerleri2 = 0.0;
            double ano = 0.00;
            //8*2 / 2
            for (int i = 0; i < sayac; i++)
            {
                // 2 *7 
                double kredidegeri = Convert.ToDouble(tbl.Rows[i][2]);
                double basaripuani = Convert.ToDouble(tbl.Rows[i][8]);
                
                anodegerleri1 += basaripuani;
                anodegerleri2 += kredidegeri;
                ano = anodegerleri1 / anodegerleri2;
                
            }
            textBox1.Text += "Gano Puanınız :" + (Math.Round(ano, 2)).ToString() +Environment.NewLine;
        }
        private void harfNotuRenk(int sayac) {
            
           for(int i=0; i < sayac; i++)
            {
                string harfnotu = Convert.ToString(tbl.Rows[i][6]);
                DataGridViewCellStyle rowColor = new DataGridViewCellStyle();

                if (harfnotu == "AA" || harfnotu =="BA" || harfnotu==  "BB")
                {
                    //rowColor.BackColor = Color.GreenYellow;
                    dataGridView1.Rows[i].Cells[6].Style.BackColor = Color.GreenYellow;
                }
                else if(harfnotu == "CC" || harfnotu == "CB")
                {
                    //rowColor.BackColor = Color.DarkOrange;
                    dataGridView1.Rows[i].Cells[6].Style.BackColor = Color.DarkOrange;

                }
                else if (harfnotu == "DD" || harfnotu == "DC")
                {
                    //rowColor.BackColor = Color.Yellow;
                    dataGridView1.Rows[i].Cells[6].Style.BackColor = Color.Yellow;

                }
                else if (harfnotu == "FF" || harfnotu == "FD")
                {
                    //rowColor.BackColor = Color.Red;
                    dataGridView1.Rows[i].Cells[6].Style.BackColor = Color.Red;

                }
               
                //rowColor.ForeColor = Color.White;
                //dataGridView1.Rows[i].Cells[i].Style.BackColor = Color.Red;
                //dataGridView1.Rows[i].DefaultCellStyle = rowColor;

            }

        }


        private void sadeceHarfNotu(int sayac)
        {
            
            double katsayisi = 0;
            for (int i = 0; i < sayac; i++)
            {
                // 6 harf notu 7 basaripuanı
                string harfNotu =  Convert.ToString(tbl.Rows[i][6]);
                if (harfNotu == "AA") { katsayisi = 4.00; }
                if (harfNotu == "BA") { katsayisi = 3.50; }
                if (harfNotu == "BB") { katsayisi = 3.00; }
                if (harfNotu == "CB") { katsayisi = 2.50; }
                if (harfNotu == "CC") { katsayisi = 2.00; }
                if (harfNotu == "DC") { katsayisi = 1.50; }
                if (harfNotu == "DD") { katsayisi = 1.00; }
                if (harfNotu == "FD") { katsayisi = 0.50; }
                if (harfNotu == "FF") { katsayisi = 0.00; }
                tbl.Rows[i][7] = katsayisi;
            }
            
        }





        private void dataGridView1_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            dataGridView1.DefaultCellStyle.SelectionForeColor = Color.Red;
            //dataGridView1.Rows[e.RowIndex].DefaultCellStyle.BackColor = Color.Red;
        }

        private void cikisYapToolStripMenuItem_Click(object sender, EventArgs e)
        {
            this.Close();
        }

        private void çıktısınıAlToolStripMenuItem_Click(object sender, EventArgs e)
        {
            iTextSharp.text.pdf.BaseFont STF_Helvetica_Turkish = iTextSharp.text.pdf.BaseFont.CreateFont("Helvetica", "CP1254", iTextSharp.text.pdf.BaseFont.NOT_EMBEDDED);
            iTextSharp.text.Font fontNormal = new iTextSharp.text.Font(STF_Helvetica_Turkish, 12, iTextSharp.text.Font.NORMAL);
            PdfPTable pdfTable = new PdfPTable(dataGridView1.ColumnCount);
            pdfTable.DefaultCell.Padding = 3;
            pdfTable.WidthPercentage = 30;
            pdfTable.HorizontalAlignment = Element.ALIGN_LEFT;
            pdfTable.DefaultCell.BorderWidth = 1;

            foreach (DataGridViewColumn column in dataGridView1.Columns)
            {
                PdfPCell cell = new PdfPCell(new Phrase(column.HeaderText, fontNormal));
                pdfTable.AddCell(cell);
            }

            int row = dataGridView1.Rows.Count;
            int cell2 = dataGridView1.Rows[1].Cells.Count;
            for (int i = 0; i < row - 1; i++)
            {
                for (int j = 0; j < cell2; j++)
                {
                    if (dataGridView1.Rows[i].Cells[j].Value == null)
                    {

                        dataGridView1.Rows[i].Cells[j].Value = "null";
                    }
                    pdfTable.AddCell(dataGridView1.Rows[i].Cells[j].Value.ToString());


                }
            }
        
            string folderPath = @"C:\pdf\";

            if (!Directory.Exists(folderPath))
            {
                Directory.CreateDirectory(folderPath);
            }
            using (FileStream stream = new FileStream(folderPath + "UcakTeknolojisiNotOrtalaması.pdf", FileMode.Create))
            {
                Document pdfDoc = new Document(PageSize.A2, 10f, 10f, 10f, 0f);
                PdfWriter.GetInstance(pdfDoc, stream);
                pdfDoc.Open();
                pdfDoc.Add(pdfTable);
                pdfDoc.Close();
                stream.Close();
            }
            MessageBox.Show("PDF Oluşturuldu " + folderPath);
        }

        private void kullanımıHakkındaToolStripMenuItem_Click(object sender, EventArgs e)
        {
            MessageBox.Show("Kullanım Aşamalari" + Environment.NewLine +
                            "1) Bulundugunuz donemi secerek \"Başlat\" düğmesine basiniz." + Environment.NewLine +
                            "2) Isterseniz vize ve final notunuzu , isterseniz sadace harf notunuzu giriniz"+Environment.NewLine+
                            "2.1) Vize ve final notlarinizi giriniz. " + Environment.NewLine +
                            "2.2) Harf notunuzunu giriniz." + Environment.NewLine +
                            "3) Degerleri eksiksik girdikden sonra \"Not ortalamasi hesapla basiniz");

                    
        }

        private void buProgramKiminİçinHazirlandiToolStripMenuItem_Click(object sender, EventArgs e)
        {
            MessageBox.Show("Bu program İstanbul Gelişim Üniversitesi Uçak Teknolojisi Bölümü için hazirlanmiştir");
        }

        private void copyrightToolStripMenuItem_Click(object sender, EventArgs e)
        {
            MessageBox.Show("Bu program \" Batuhan Atabey \" tarafindan hazirlanmistir"); 
        }

        private void label2_Click(object sender, EventArgs e)
        {

        }

        private void ganoHesaplama_Click(object sender, EventArgs e)
        {
            int donemsayisi = int.Parse(comboBox1.Text);
            int sayac = 0;
            if (donemsayisi == 1) sayac = 8;
            if (donemsayisi == 2) sayac = 16;
            if (donemsayisi == 3) sayac = 24;
            if (donemsayisi == 4) sayac = 32;
            if (radioButton1.Checked)
            {
            
                for (int d = 0; d < sayac; d++)
                {
                    double vize = Convert.ToDouble(tbl.Rows[d][3]);
                    double final = Convert.ToDouble(tbl.Rows[d][4]);
                    tbl.Rows[d][5] = NotOrtalamaHesapla(vize, final);

                }
                harfNotlarıEkle(sayac);
                basariPuanEtkisi(sayac);
                GanohesapLa(sayac);
                harfNotuRenk(sayac);

                
            }
            else if (radioButton2.Checked)
            {
                sadeceHarfNotu(sayac);
                basariPuanEtkisi(sayac);
                GanohesapLa(sayac);
                harfNotuRenk(sayac);
            }

            else
            {
                MessageBox.Show("Lutfen bir islem seciniz");
            }
        }

        private void groupBox1_Enter(object sender, EventArgs e)
        {

        }

        private void yetkiliPanelToolStripMenuItem_Click(object sender, EventArgs e)
        {
            GirisPanel YetkiliGiris = new GirisPanel();
            YetkiliGiris.Show();
        }
    }
}
