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
    public partial class imza : Form
    {
        public imza()
        {
            InitializeComponent();
        }

        private void imza_Load(object sender, EventArgs e)
        {

        }
        bool ciz;
        int baslaX, baslaY;



        private void imza_MouseDown(object sender, MouseEventArgs e)
        {
            ciz = true;
            baslaX = e.X;
            baslaY = e.Y;
        }

        private void imza_MouseMove(object sender, MouseEventArgs e)
        {
            Graphics g = this.CreateGraphics();

            Pen p = new Pen(Color.Blue, 3);

            Point point1 = new Point(baslaX, baslaY);
            Point point2 = new Point(e.X, e.Y);
            if (ciz == true)
            {
                g.DrawLine(p, point1, point2);
                baslaX = e.X;
                baslaY = e.Y;
            }
        }

        private void imza_MouseUp(object sender, MouseEventArgs e)
        {
            ciz = false;
        }

    
    }
}
