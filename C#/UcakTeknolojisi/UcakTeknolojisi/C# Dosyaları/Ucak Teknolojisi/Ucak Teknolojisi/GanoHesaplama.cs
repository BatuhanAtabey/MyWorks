﻿using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Data.SqlClient;
using System.IO;
using iTextSharp.text;
using iTextSharp.text.pdf;

namespace Ucak_Teknolojisi
{
    public partial class GanoHesaplama : Form
    {
        public GanoHesaplama()
        {
            InitializeComponent();
        }
        DataTable tbl = new DataTable();
        DataTable NotOrtTbl = new DataTable();
        DataTable harfNotlaritbl = new DataTable();
        DataTable EskiHarfNotutbl = new DataTable();
        private void GanoHesaplama_Load(object sender, EventArgs e)
        {
            groupBox3.Hide();
            dataGridView3.Hide();
            EskiHarfNotutbl.Columns.Add("Yeni Harf Notu");
            EskiHarfNotutbl.Columns.Add("Eski Harf Notu");
            EskiHarfNotutbl.Columns.Add("Değiştirilen Harf Notu");
            NotOrtTbl.Columns.Add("Ortalama Türü");
            NotOrtTbl.Columns.Add("Not Ortalaması");
            tbl.Columns.Add("Donem");
            tbl.Columns.Add("Ders Kodu");
            tbl.Columns.Add("Ders İsmi");
            tbl.Columns.Add("Kredi");
            tbl.Columns.Add("Vize");
            tbl.Columns.Add("Final");
            tbl.Columns.Add("Not Ortalamasi");
            tbl.Columns.Add("Harf Notu");
            tbl.Columns.Add("Eski Harf Notu");
            tbl.Columns.Add("Kat Sayisi");
            tbl.Columns.Add("Ortalama Etkisi");
            dataGridView1.EnableHeadersVisualStyles = false;
            dataGridView1.ColumnHeadersDefaultCellStyle.ForeColor = Color.Blue;
        }
        SqlConnection baglan = new SqlConnection("Data Source=desktop-nltfpct\\sqlexpress;Initial Catalog=UcakTeknolojisi;Integrated Security=True");
        private void Donem1Dersler()
        {
            baglan.Open();
            SqlCommand komut = new SqlCommand("select * from Dersler where d_donem=1", baglan);
           
            SqlDataReader oku = komut.ExecuteReader();
            
            while (oku.Read())
            {

                //donem dersismi kredi
                tbl.Rows.Add(oku["d_donem"].ToString(), oku["d_kod"], oku["d_adi"], oku["d_kredi"].ToString());

            }
            baglan.Close();
        }
        private void Donem2Dersler()
        {
            baglan.Open();
            SqlCommand komut = new SqlCommand("select * from Dersler where d_donem=2", baglan);

            SqlDataReader oku = komut.ExecuteReader();

            while (oku.Read())
            {

                //donem dersismi kredi
                tbl.Rows.Add(oku["d_donem"].ToString(), oku["d_kod"], oku["d_adi"], oku["d_kredi"].ToString());

            }
            baglan.Close();
        }
        private void Donem3Dersler()
        {
            baglan.Open();
            SqlCommand komut = new SqlCommand("select * from Dersler where d_donem=3", baglan);

            SqlDataReader oku = komut.ExecuteReader();

            while (oku.Read())
            {

                //donem dersismi kredi
                tbl.Rows.Add(oku["d_donem"].ToString(), oku["d_kod"], oku["d_adi"], oku["d_kredi"].ToString());

            }
            baglan.Close();
        }
        private void Donem4Dersler()
        {
            baglan.Open();
            SqlCommand komut = new SqlCommand("select * from Dersler where d_donem=4", baglan);

            SqlDataReader oku = komut.ExecuteReader();

            while (oku.Read())
            {

                //donem dersismi kredi
                tbl.Rows.Add(oku["d_donem"].ToString(), oku["d_kod"], oku["d_adi"], oku["d_kredi"].ToString());

            }
            baglan.Close();
        }
        private void button2_Click(object sender, EventArgs e)
        {
            label1.Text = "";
            label2.Text = "";
            label4.Text = "";
            label5.Text = "";
            tbl.Clear();

            if (tekDonemRadio.Checked == true)
            {
                label1.Text = "1";
                if (comboBox1.Text == "1") { Donem1Dersler(); }
                if (comboBox1.Text == "2") { Donem2Dersler(); }
                if (comboBox1.Text == "3") { Donem3Dersler(); }
                if (comboBox1.Text == "4") { Donem4Dersler(); }
            }
            if(sonDonemRadio.Checked == true)
            {
                if (comboBox1.Text == "1")
                {
                    Donem1Dersler();
                    label1.Text = "1";

                }
                if (comboBox1.Text == "2")
                {
                     Donem1Dersler();
                     Donem2Dersler();
                    label2.Text = "2";


                }
                if (comboBox1.Text == "3")
                {
                    Donem1Dersler();
                    Donem2Dersler();
                    Donem3Dersler();
                    label4.Text = "3";

                }
                if (comboBox1.Text == "4")
                {
                    Donem1Dersler();
                    Donem2Dersler();
                    Donem3Dersler();
                    Donem4Dersler();
                    label5.Text = "4";
                }

            }



            int a = tbl.Rows.Count;
            label6.Text = a.ToString();
            dataGridView1.DataSource = tbl;
        }
        // GANO ANO HESAPLAMA VE KAYDETME
        private void notilehesapla()
        {
            int satirsayisi;
            satirsayisi = int.Parse(label6.Text);
            double vize, final, notortalamasi;
            string harfNotu = "";
            double katsayisi = 0;
            double ortetkisi = 0;
            double kredi = 0;
            string vizekontrol = "";
            string finalkontrol = "";
            
            for(int i = 0; i < satirsayisi; i++)
            {
                vizekontrol = Convert.ToString(tbl.Rows[i][4]);
                finalkontrol = Convert.ToString(tbl.Rows[i][4]);
                if (vizekontrol == "G" || finalkontrol == "G")
                {
                    tbl.Rows[i][4] = "G";
                    tbl.Rows[i][5] = "G";
                    tbl.Rows[i][6] = "G";
                    tbl.Rows[i][7] = "G";
                    tbl.Rows[i][8] = "G";
                    tbl.Rows[i][9] = "G";
                    tbl.Rows[i][10] = "G";
                }
                else
                {
                    vize = Convert.ToDouble(tbl.Rows[i][4]);
                    final = Convert.ToDouble(tbl.Rows[i][5]);
                    notortalamasi = (vize * 0.4) + (final * 0.6);
                    tbl.Rows[i][6] = (Math.Round(notortalamasi, 2)).ToString();

                    if (notortalamasi <= 100 && notortalamasi >= 90) { harfNotu = "AA"; katsayisi = 4.00; }
                    if (notortalamasi <= 89 && notortalamasi >= 85) { harfNotu = "BA"; katsayisi = 3.50; }
                    if (notortalamasi <= 84 && notortalamasi >= 75) { harfNotu = "BB"; katsayisi = 3.00; }
                    if (notortalamasi <= 74 && notortalamasi >= 65) { harfNotu = "CB"; katsayisi = 2.50; }
                    if (notortalamasi <= 64 && notortalamasi >= 60) { harfNotu = "CC"; katsayisi = 2.00; }
                    if (notortalamasi <= 59 && notortalamasi >= 50) { harfNotu = "DC"; katsayisi = 1.50; }
                    if (notortalamasi <= 49 && notortalamasi >= 45) { harfNotu = "DD"; katsayisi = 1.00; }
                    if (notortalamasi <= 44 && notortalamasi >= 40) { harfNotu = "FD"; katsayisi = 0.50; }
                    if (notortalamasi <= 39 && notortalamasi >= 00) { harfNotu = "FF"; katsayisi = 0.00; }
                    tbl.Rows[i][7] = harfNotu;
                    tbl.Rows[i][9] = katsayisi;

                    kredi = Convert.ToDouble(tbl.Rows[i][3]);

                    ortetkisi = kredi * katsayisi;
                    tbl.Rows[i][10] = ortetkisi;

                }
            }
            
        }
        private void harfnotuilehesapla()
        {
            int satirsayisi;
            satirsayisi = int.Parse(label6.Text);
            string harfNotu = "";
            double katsayisi = 0;
            double kredi = 0;
            double ortetkisi = 0;
            
            for(int i = 0; i < satirsayisi; i++)
            {
                harfNotu = Convert.ToString(tbl.Rows[i][7]);
                if (harfNotu == "G")
                {
                    tbl.Rows[i][9] = "G";
                    tbl.Rows[i][10] = "G";
                }
                else
                {
                    if (harfNotu == "AA") katsayisi = 4.00;
                    if (harfNotu == "BA") katsayisi = 3.50;
                    if (harfNotu == "BB") katsayisi = 3.00;
                    if (harfNotu == "CB") katsayisi = 2.50;
                    if (harfNotu == "CC") katsayisi = 2.00;
                    if (harfNotu == "DC") katsayisi = 1.50;
                    if (harfNotu == "DD") katsayisi = 1.00;
                    if (harfNotu == "FD") katsayisi = 0.50;
                    if (harfNotu == "FF") katsayisi = 0.00;

                    tbl.Rows[i][9] = katsayisi;
                    kredi = Convert.ToDouble(tbl.Rows[i][3]);

                    ortetkisi = kredi * katsayisi;
                    tbl.Rows[i][10] = ortetkisi;
                }
            }
        }
        private void renkVer()
        {
            int satirsayisi;
            satirsayisi = int.Parse(label6.Text);
            for (int i = 0; i < satirsayisi; i++)
            {
                string harfnotu = Convert.ToString(tbl.Rows[i][7]);
                DataGridViewCellStyle rowColor = new DataGridViewCellStyle();

                if (harfnotu == "AA" || harfnotu == "BA" || harfnotu == "BB")
                {dataGridView1.Rows[i].Cells[7].Style.BackColor = Color.GreenYellow;}
                else if (harfnotu == "CC" || harfnotu == "CB")
                { dataGridView1.Rows[i].Cells[7].Style.BackColor = Color.DarkOrange; }
                else if (harfnotu == "DD" || harfnotu == "DC")
                {  dataGridView1.Rows[i].Cells[7].Style.BackColor = Color.Yellow;}
                else if (harfnotu == "FF" || harfnotu == "FD")
                { dataGridView1.Rows[i].Cells[7].Style.BackColor = Color.Red;}
            }
        }
        private void NaNCozum()
        {
            // 2.Tablo icin
            string ano1 = Convert.ToString(NotOrtTbl.Rows[0][1]);
            string ano2 = Convert.ToString(NotOrtTbl.Rows[1][1]);
            string ano3 = Convert.ToString(NotOrtTbl.Rows[2][1]);
            string ano4 = Convert.ToString(NotOrtTbl.Rows[3][1]);
            if (ano1 == "NaN") { NotOrtTbl.Rows[0][1] = 0; label9.Text = "0"; }
            if (ano2 == "NaN") {NotOrtTbl.Rows[1][1] = 0; label10.Text = "0"; }
            if (ano3 == "NaN") {NotOrtTbl.Rows[2][1] = 0; label11.Text = "0";}
            if (ano4 == "NaN") {NotOrtTbl.Rows[3][1] = 0; label12.Text = "0";}
            // 1.Tablo icin
            //string ano11 = Convert.ToString(tbl.Rows[0][12]);
            //string ano22 = Convert.ToString(tbl.Rows[1][12]);
            //string ano33 = Convert.ToString(tbl.Rows[2][12]);
            //string ano44 = Convert.ToString(tbl.Rows[3][12]);
            //if(ano11 == "NaN") { tbl.Rows[0][12] = 0; }
            //if (ano22 == "NaN") { tbl.Rows[1][12] = 0; }
            //if (ano33 == "NaN") { tbl.Rows[2][12] = 0; }
            //if (ano44 == "NaN") { tbl.Rows[3][12] = 0; }
        }
        private void GanoEkle()
        {
            double ano1 = Convert.ToDouble(NotOrtTbl.Rows[0][1]);
            double ano2 = Convert.ToDouble(NotOrtTbl.Rows[1][1]);
            double ano3 = Convert.ToDouble(NotOrtTbl.Rows[2][1]);
            double ano4 = Convert.ToDouble(NotOrtTbl.Rows[3][1]);
            double gano = 0;
            double bolunuceksayi = 0.00;
            if (label1.Text == "1") bolunuceksayi = 1.00;
            if (label2.Text == "2") bolunuceksayi = 2.00;
            if (label4.Text == "3") bolunuceksayi = 3.00;
            if (label5.Text == "4") bolunuceksayi = 4.00;
            gano = (ano1 + ano2 + ano3 + ano4) / bolunuceksayi;
            NotOrtTbl.Rows.Add("Gano", Math.Round(gano, 2));
           
            label13.Text = Math.Round(gano, 2).ToString();
            
        }
        private void NotOrtlamalariEkle()
        {
            NotOrtTbl.Clear();
            double gano = 0; double ano1 = 0; double ano2 = 0; double ano3 = 0; double ano4 = 0;

            double anoust1 = 0; double anoust2 = 0; double anoust3 = 0; double anoust4 = 0;
            double anoalt1 = 0; double anoalt2 = 0; double anoalt3= 0; double anoalt4 = 0;
            int satirsayisi;
            satirsayisi = int.Parse(label6.Text);
            for (int i = 0; i < satirsayisi; i++)
            {
               double donemnumarasi = Convert.ToDouble(tbl.Rows[i][0]);
                double kredi = Convert.ToDouble(tbl.Rows[i][3]);
               
                string anoetkisigecerlimi = Convert.ToString(tbl.Rows[i][10]);
                if (anoetkisigecerlimi == "G")
                {

                }
                else
                {
                    double anoetkisi = Convert.ToDouble(tbl.Rows[i][10]);
                    if (donemnumarasi == 1)
                    {
                        anoust1 += anoetkisi;
                        anoalt1 += kredi;
                    }
                    if (donemnumarasi == 2)
                    {
                        anoust2 += anoetkisi;
                        anoalt2 += kredi;
                    }
                    if (donemnumarasi == 3)
                    {
                        anoust3 += anoetkisi;
                        anoalt3 += kredi;
                    }
                    if (donemnumarasi == 4)
                    {
                        anoust4 += anoetkisi;
                        anoalt4 += kredi;
                    }
                }

            }
            ano1 = anoust1 / anoalt1;
            ano2 = anoust2 / anoalt2;
            ano3 = anoust3 / anoalt3;
            ano4 = anoust4 / anoalt4;

            label9.Text = Math.Round(ano1, 2).ToString();
            label10.Text = Math.Round(ano2, 2).ToString();
            label11.Text = Math.Round(ano3, 2).ToString();
            label12.Text = Math.Round(ano4, 2).ToString();
            NotOrtTbl.Rows.Add("1.Dönem Ano", Math.Round(ano1,2));
            NotOrtTbl.Rows.Add("2.Dönem Ano", Math.Round(ano2, 2));
            NotOrtTbl.Rows.Add("3.Dönem Ano", Math.Round(ano3, 2));
            NotOrtTbl.Rows.Add("4.Dönem Ano", Math.Round(ano4, 2));
            NaNCozum();
            GanoEkle();
            dataGridView2.DataSource = NotOrtTbl;
           

        }
        
        private void anoGanolariEkle()
        {
            int satirsayisi;
            satirsayisi = int.Parse(label6.Text);
            string ogrencino = textBox1.Text;
            int sayac = 0;
            string[] kalandersler = new string[99];
            string[] kalanderslerHarf = new string[99];
            string harfNotu = "";
            string dersismi = "";
            for(int i =0; i < satirsayisi; i++)
            {
                harfNotu = Convert.ToString(tbl.Rows[i][7]);
                dersismi = Convert.ToString(tbl.Rows[i][2]);
                if (harfNotu == "FD" || harfNotu == "FF")
                {
                    sayac++;
                    kalandersler[sayac] = dersismi;
                    kalanderslerHarf[sayac] = harfNotu;
                }
            }
            tbl.Rows.Add("-");
            tbl.Rows[satirsayisi][5] = "Ucak Teknolojisi Not Hesaplama";
            tbl.Rows[satirsayisi][6] = "Ogenci No:"+ogrencino;
            tbl.Rows.Add("-");
            tbl.Rows[satirsayisi + 1][5] = ("1 Yarıyıl : " + NotOrtTbl.Rows[0][1]);
            tbl.Rows[satirsayisi + 1][6] = ("2 Yarıyıl : " + NotOrtTbl.Rows[1][1]);
            tbl.Rows.Add("-");
            tbl.Rows[satirsayisi + 2][5] = ("3 Yarıyıl : " + NotOrtTbl.Rows[2][1]);
            tbl.Rows[satirsayisi + 2][6] = ("4 Yarıyıl : " + NotOrtTbl.Rows[3][1]);
            tbl.Rows.Add("-");
            tbl.Rows[satirsayisi + 3][5] = "Alınması Gereken Dersler";
            tbl.Rows[satirsayisi + 3][6] = "Tahir Soyugüzel";
            for(int i = 0; i <= sayac; i++)
            {
                tbl.Rows.Add("-");
                tbl.Rows[satirsayisi + 3 + i+1][5] = kalandersler[i];
                tbl.Rows[satirsayisi + 3 + i+1][6] = kalanderslerHarf[i];
            }
        }

        private void eskiharfNotu()
        {
            int satirsayisi;
            satirsayisi = int.Parse(label6.Text);
            string harfNotu = "";
            for (int i = 0; i < satirsayisi; i++)
            {
                harfNotu = Convert.ToString(tbl.Rows[i][7]);
                EskiHarfNotutbl.Rows.Add(harfNotu);

            }

        }
        private void yeniharfNotu()
        {
            int satirsayisi;
            satirsayisi = int.Parse(label6.Text);
            string harfNotu = "";
            for (int i = 0; i < satirsayisi; i++)
            {
                harfNotu = Convert.ToString(tbl.Rows[i][7]);
                EskiHarfNotutbl.Rows[i][1] = (harfNotu);

            }
        }
        private void degisenharfNotunuEkle()
        {
            int satirsayisi;
            satirsayisi = int.Parse(label6.Text);
            string harfNotu1= "";
            string harfNotu2 = "";
            for (int i = 0; i < satirsayisi; i++)
            {
                harfNotu1 = Convert.ToString(EskiHarfNotutbl.Rows[i][0]);
                harfNotu2 = Convert.ToString(EskiHarfNotutbl.Rows[i][1]);
                if(harfNotu1 != harfNotu2)
                {
                    
                    tbl.Rows[i][8] = EskiHarfNotutbl.Rows[i][0];
                    if(tbl.Rows[i][7] == tbl.Rows[i][8])
                    {
                        tbl.Rows[i][8] = "-";
                    }
                }

            }
        }
        
        private void Hesaplama_click()
        {
            
            if (vizeFinal.Checked == true)
            {
                notilehesapla();
            }
            if (harfNotu.Checked == true)
            {
                harfnotuilehesapla();
            }
            renkVer();
            NotOrtlamalariEkle();
            anoGanolariEkle();
            sayac++;
            if (sayac == 1) eskiharfNotu();
            else if (sayac == 2) { yeniharfNotu(); sayac = 0; }
            degisenharfNotunuEkle();
            dataGridView3.DataSource = EskiHarfNotutbl;
            dataGridView1.DataSource = tbl;
        }
        int sayac = 0;
        
        private void button1_Click(object sender, EventArgs e)
        {

            label15.Text = "";
            Hesaplama_click();
            
            
        }
        
        private void kullanımıHakkındaToolStripMenuItem_Click(object sender, EventArgs e)
        {
            MessageBox.Show("Kullanım Aşamalari" + Environment.NewLine +
                          "1) Bulundugunuz donemi secerek \"Başlat\" düğmesine basiniz." + Environment.NewLine +
                          "2) Isterseniz vize ve final notunuzu , isterseniz sadace harf notunuzu giriniz" + Environment.NewLine +
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

        private void yetkiliPanelToolStripMenuItem_Click(object sender, EventArgs e)
        {
            GirisPanel girisPanel = new GirisPanel();
            girisPanel.Show();
        }

        private void cikisYapToolStripMenuItem_Click(object sender, EventArgs e)
        {
            this.Close();
        }
        private void anoganolarıSqlSil()
        {
            string ogno = textBox1.Text;
            baglan.Open();
            SqlCommand komut = new SqlCommand("delete from  OgrenciBilgiler where og_no=(" + ogno + ")", baglan);
            komut.ExecuteNonQuery();
            baglan.Close();
        }
        private void silButonu()
        {
            string ogno = textBox1.Text;
            baglan.Open();
            SqlCommand komut = new SqlCommand("delete from Notlar2 where og_no=(" + ogno + ")", baglan);
            komut.ExecuteNonQuery();
            baglan.Close();
            anoganolarıSqlSil();
        }
        private void btnSil_Click(object sender, EventArgs e)
        {

            silButonu();
        }
        private void NotlariSqleEkleme()
        {
            baglan.Open();
            int satirsayisi;
            satirsayisi = int.Parse(label6.Text);


            for (int i = 0; i < satirsayisi; i++)
            {
                string donem = Convert.ToString(tbl.Rows[i][0]);
                string derskodu = Convert.ToString(tbl.Rows[i][1]);
                string dersismi = Convert.ToString(tbl.Rows[i][2]);
                string kredi = Convert.ToString(tbl.Rows[i][3]);
                string vize = Convert.ToString(tbl.Rows[i][4]);
                string final = Convert.ToString(tbl.Rows[i][5]);
                string notort = Convert.ToString(tbl.Rows[i][6]);
                string harfNotu1 = Convert.ToString(tbl.Rows[i][7]);
                string harfNotu2 = Convert.ToString(tbl.Rows[i][8]);
                string katsayisi = Convert.ToString(tbl.Rows[i][9]);
                string anoganoetkisi = Convert.ToString(tbl.Rows[i][10]);

                SqlCommand komut = new SqlCommand("insert into Notlar2 (og_no,donem,derskodu,dersismi,kredi,vize,final,notort,harfnotu,harfnotu2,katsayisi,ortetkisi) values (@og_no,@donem,@derskodu,@dersismi,@kredi,@vize,@final,@notort,@harfnotu1,@harfnotu2,@katsayisi,@ortetkisi)", baglan);
                komut.Parameters.AddWithValue("@og_no", textBox1.Text);
                komut.Parameters.AddWithValue("@donem", donem);
                komut.Parameters.AddWithValue("@derskodu", derskodu);
                komut.Parameters.AddWithValue("@dersismi", dersismi);
                komut.Parameters.AddWithValue("@kredi", kredi);
                komut.Parameters.AddWithValue("@vize", vize);
                komut.Parameters.AddWithValue("@final", final);
                komut.Parameters.AddWithValue("@notort", notort);
                komut.Parameters.AddWithValue("@harfnotu1", harfNotu1);
                komut.Parameters.AddWithValue("@harfnotu2", harfNotu2);
                komut.Parameters.AddWithValue("@katsayisi", katsayisi);
                komut.Parameters.AddWithValue("@ortetkisi", anoganoetkisi);
                komut.ExecuteNonQuery();
            }
            
            baglan.Close();
        }
        private void kaydetButtonu()
        {
            baglan.Open();
            SqlCommand komut = new SqlCommand("insert into OgrenciBilgiler (og_no,og_ano1,og_ano2,og_ano3,og_ano4,og_gano) values (@ogno,@ano1,@ano2,@ano3,@ano4,@gano)", baglan);
            komut.Parameters.AddWithValue("@ogno", textBox1.Text);
            komut.Parameters.AddWithValue("@ano1", label9.Text);
            komut.Parameters.AddWithValue("@ano2", label10.Text);
            komut.Parameters.AddWithValue("@ano3", label11.Text);
            komut.Parameters.AddWithValue("@ano4", label12.Text);
            komut.Parameters.AddWithValue("@gano", label13.Text);
            komut.ExecuteNonQuery();
            baglan.Close();

            NotlariSqleEkleme();
        }
        private void btnKaydet_Click(object sender, EventArgs e)
        {
            kaydetButtonu();

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
            MessageBox.Show("Not ortalaması PDF Belgeniz Olusturuldu.Dosya yolu :" + folderPath);
        }

        private void btnGuncelle_Click(object sender, EventArgs e)
        {
            silButonu();
            kaydetButtonu();
        }

        private void dataGridView1_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {

        }
        private void ganoAnolarıTabloEkle()
        {
            NotOrtTbl.Clear();
            baglan.Open();
            SqlCommand komut2 = new SqlCommand("select * from OgrenciBilgiler where og_no=@ogno", baglan);
            komut2.Parameters.AddWithValue("@ogno", textBox1.Text);
            SqlDataReader oku2 = komut2.ExecuteReader();
            while (oku2.Read())
            {
                NotOrtTbl.Rows.Add("1. Dönem Ano", oku2["og_ano1"]);
                NotOrtTbl.Rows.Add("2. Dönem Ano", oku2["og_ano2"]);
                NotOrtTbl.Rows.Add("3. Dönem Ano", oku2["og_ano3"]);
                NotOrtTbl.Rows.Add("4. Dönem Ano", oku2["og_ano4"]);
                NotOrtTbl.Rows.Add("Gano", oku2["og_gano"]);

            }
            
            baglan.Close();
            dataGridView2.DataSource = NotOrtTbl;
        }
        private void verilerigoruntule()
        {
            tbl.Clear();
            
            baglan.Open();
            SqlCommand komut = new SqlCommand("select * from Notlar2 where og_no=@ogno", baglan);
            komut.Parameters.AddWithValue("@ogno", textBox1.Text);
            SqlDataReader oku = komut.ExecuteReader();
            while (oku.Read())
            {
                tbl.Rows.Add(oku["donem"], oku["derskodu"], oku["dersismi"], oku["kredi"], oku["vize"], oku["final"], oku["notort"], oku["harfnotu"], oku["harfnotu2"], oku["katsayisi"], oku["ortetkisi"]);

            }
            
            baglan.Close();
            dataGridView1.DataSource = tbl;
           
        }
       
        private void button3_Click(object sender, EventArgs e)
        {
            verilerigoruntule();
            ganoAnolarıTabloEkle();
            tbl.Rows.Add("-");
            int a = tbl.Rows.Count ;
            label6.Text = a.ToString();
           
            
            
        }

        private void button4_Click(object sender, EventArgs e)
        {
            MessageBox.Show("Hangi dönemde işlem yapmak istediğinizi seciniz" + Environment.NewLine +
                           "Daha sonra başlat düğmesine basınız.");
        }

        private void button5_Click(object sender, EventArgs e)
        {
            MessageBox.Show("Not ortlamanızı nasil hesaplamak istediginizi seciniz." + Environment.NewLine +
                "Degerleri girdikden sonra Hesapla düğmesine basınız");
        }

        private void button6_Click(object sender, EventArgs e)
        {
            MessageBox.Show("Öğrenci numaranızı girdikden sonra"+Environment.NewLine+
                "- BILGILERI GETIR : Kayıt ettiginiz notlarınızı getirmek için goruntuleme buttonuna basınız." + Environment.NewLine +
                "- KAYDET : Hesapladiginiz degerleri kaydetmek icin kaydet buttonuna basınız."+Environment.NewLine+
                "- SİL : Sistemde kayıtlı olan notlarınızı silmek için sil buttonuna basınız."+Environment.NewLine+
                "- GÜNCELLE: Sistemdeki mevcut notlarınızı güncellemek için güncelle buttonuna basınız.");
        }

        private void button7_Click(object sender, EventArgs e)
        {
            tbl.Clear();
            NotOrtTbl.Clear();
            dataGridView1.DataSource = tbl;
            dataGridView2.DataSource = NotOrtTbl;
        }

    }
}
