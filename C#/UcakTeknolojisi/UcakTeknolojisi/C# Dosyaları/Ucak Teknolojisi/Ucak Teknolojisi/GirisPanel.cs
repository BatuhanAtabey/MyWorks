using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace Ucak_Teknolojisi
{
    public partial class GirisPanel : Form
    {
        public GirisPanel()
        {
            InitializeComponent();
        }

        private void btnGiris_Click(object sender, EventArgs e)
        {

            OgretmenPanel ogrtPanel = new OgretmenPanel();
            if (textBox1.Text == "tahir" && textBox2.Text == "gelisim")
            {
                ogrtPanel.Show();
                this.Hide();

            }
            else
            {
                MessageBox.Show("Sifre Hatali!");
            }

        }


    }
}
