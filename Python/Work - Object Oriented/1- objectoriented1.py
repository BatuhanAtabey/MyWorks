class Araba():
    def __init__(self, model="Null", renk="Null", beygir_gücü=0, silindir=0) -> None:
        print("Ozellikler")
        self.model = model
        self.renk = renk
        self.beygir_gücü = beygir_gücü
        self.silindir = silindir


araba1 = Araba("Renault","Silver",101,4)

print(araba1.model)

araba2 = Araba(beygir_gücü=50)
print(araba2.model)