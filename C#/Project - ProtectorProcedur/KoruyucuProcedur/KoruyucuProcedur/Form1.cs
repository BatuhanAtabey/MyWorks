using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace KoruyucuProcedur
{
    public partial class Form1 : Form
    {
 

        public Form1()
        {
            InitializeComponent();

        }

        private void Form1_Load(object sender, EventArgs e)
        {

        }

        private void button1_Click(object sender, EventArgs e)
        {

            string isim, tcno, derece, dakika, saniye, sifre;
            bool durum;
            isim = Convert.ToString(textBox8.Text);
            tcno = Convert.ToString(textBox6.Text);
            derece = Convert.ToString(textBox1.Text);
            dakika = Convert.ToString(textBox2.Text);
            saniye = Convert.ToString(textBox3.Text);
            durum = Convert.ToBoolean(textBox4.Text);
            sifre = Convert.ToString(textBox5.Text);
            MessageBox.Show("Talebiniz iletildi");
            label15.Text = "Askeri üsden onay bekleniyor";

               string askerbilgiler = " ";

            askerbilgiler +="Asker Bilgileri" + Environment.NewLine +
                            "Ad Soyad :" + isim + Environment.NewLine +
                            "TC NO :" + tcno + Environment.NewLine;
            askerbilgiler += Environment.NewLine+
                                "Koordinat Bilgileri"+Environment.NewLine+
                                "Derece : "+derece + Environment.NewLine + 
                                "Dakika : "+dakika + Environment.NewLine +
                                "Saniye : "+saniye + Environment.NewLine
                                ;


            if (sifre == "asker")
            {
                askerbilgiler += Environment.NewLine+
                                 "Sifre Durumu" + Environment.NewLine +
                                 "Sifre Dogrulandı" + Environment.NewLine;
                if (durum == false)
                {
                    askerbilgiler +=
                        Environment.NewLine+
                        "Asker Durumu" + Environment.NewLine+
                        "Asker hedef konuma gidemiyicek durumda." + Environment.NewLine;
                }
                else
                {
                    askerbilgiler +=
                        Environment.NewLine+
                        "Asker Durumu" + Environment.NewLine +
                        "Asker Hedef konuma gidebilicek durumda." + Environment.NewLine;
                }

                

            }

            else
            {
                askerbilgiler += Environment.NewLine +
                                 "Sifre Durumu" + Environment.NewLine + 
                                 "Sifre Dogrulanamadi " + Environment.NewLine +
                                 "Asker tehdit altında !" + Environment.NewLine;
                if (durum == false)
                {
                    askerbilgiler += Environment.NewLine +
                                 "Asker Durumu" + Environment.NewLine +
                        "Asker hedef konuma gidemiyicek durumda." + Environment.NewLine;
                }
                else
                {
                    
                   askerbilgiler += Environment.NewLine +
                                "Asker Durumu" + Environment.NewLine +
                        "Asker Hedef konuma gidebilicek durumda." + Environment.NewLine;
                }

                

            }
            label10.Text = askerbilgiler;
            
        
        }

        private void textBox5_TextChanged(object sender, EventArgs e)
        {

        }

        private void label15_Click(object sender, EventArgs e)
        {

        }

        private void button2_Click(object sender, EventArgs e)
        {
          
        }

        private void label21_Click(object sender, EventArgs e)
        {

        }

        private void textBox7_TextChanged(object sender, EventArgs e)
        {

        }
    }
}
