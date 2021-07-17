using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Data.SqlClient;

namespace Ucak_Teknolojisi
{
    public partial class OgretmenPanel : Form
    {
        public OgretmenPanel()
        {
            InitializeComponent();
        }
        SqlConnection baglan = new SqlConnection("Data Source=desktop-nltfpct\\sqlexpress;Initial Catalog=UcakTeknolojisi;Integrated Security=True");
        private void verilerigoster()
        {
            listView1.Items.Clear();

            baglan.Open();
            SqlCommand komut = new SqlCommand("select * from Dersler", baglan);
            
            SqlDataReader oku = komut.ExecuteReader();

            while (oku.Read())
            {
                ListViewItem ekle = new ListViewItem();
                ekle.Text = oku["d_id"].ToString();
                ekle.SubItems.Add(oku["d_donem"].ToString());
                ekle.SubItems.Add(oku["d_kod"].ToString());
                ekle.SubItems.Add(oku["d_adi"].ToString());
                ekle.SubItems.Add(oku["d_kredi"].ToString());
                listView1.Items.Add(ekle);
            }

            baglan.Close();

        }
        private void btnKaydet_Click_1(object sender, EventArgs e)
        {
            baglan.Open();
            SqlCommand komut = new SqlCommand("insert into Dersler (d_donem,d_kod,d_adi,d_kredi) values (@donem,@kod,@adi,@kredi)", baglan);
            komut.Parameters.AddWithValue("@donem", comboBox1.Text);
            komut.Parameters.AddWithValue("@kod", textBox1.Text);
            komut.Parameters.AddWithValue("@adi", textBox2.Text);
            komut.Parameters.AddWithValue("@kredi", textBox3.Text);
            komut.ExecuteNonQuery();
            baglan.Close();
            verilerigoster();

        }
        private void button1_Click(object sender, EventArgs e)
        {
            verilerigoster();
        }


        int id = 0;
        private void btnSil_Click(object sender, EventArgs e)
        {
            baglan.Open();
            SqlCommand komut = new SqlCommand("delete from Dersler where d_id=(" + id + ")", baglan);
            komut.ExecuteNonQuery();
            baglan.Close();
            verilerigoster();
        }

        private void listView1_DoubleClick(object sender, EventArgs e)
        {
            id = int.Parse(listView1.SelectedItems[0].SubItems[0].Text);
            label5.Text = id.ToString();
            comboBox1.Text = listView1.SelectedItems[0].SubItems[1].Text;
            textBox1.Text = listView1.SelectedItems[0].SubItems[2].Text;
            textBox2.Text = listView1.SelectedItems[0].SubItems[3].Text;
            textBox3.Text = listView1.SelectedItems[0].SubItems[4].Text;
     
        }

        private void button2_Click(object sender, EventArgs e)
        {
            baglan.Open();
           
            SqlCommand komut = new SqlCommand("update Dersler set d_donem=@donem,d_kod=@derskodu,d_adi=@dersadi,d_kredi=@derskredi where d_id=@id", baglan);

            komut.Parameters.AddWithValue("@id", label5.Text);
            komut.Parameters.AddWithValue("@donem", comboBox1.Text);
            komut.Parameters.AddWithValue("@derskodu", textBox1.Text);
            komut.Parameters.AddWithValue("@dersadi", textBox2.Text);
            komut.Parameters.AddWithValue("@derskredi", textBox3.Text);

            komut.ExecuteNonQuery();
            baglan.Close();
            verilerigoster();
        }

        private void OgretmenPanel_Load(object sender, EventArgs e)
        {
            label5.Hide();
        }

        private void imzaToolStripMenuItem_Click(object sender, EventArgs e)
        {
            imza imzapanel = new imza();
            imzapanel.Show();
        }
    }
}
 