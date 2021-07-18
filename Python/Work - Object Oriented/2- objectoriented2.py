class Programmer():
    def __init__(self, name, surname, number, salary, languages):
        self.name = name
        self.surname = surname
        self.number = number
        self.salary = salary
        self.languages = languages

    def viewDetails(self):
        print("""
        
        Programmer

        Name: {}

        Surname: {}

        Number: {}

        Salary: {}

        Languages: {}
        
        
        """.format(self.name, self.surname, self.number, self.salary, self.languages))

    def salaryplus(self, howmuch):
        print("salary increases... ")
        self.salary += howmuch

    def languagesadd(self, language):
        print("language upload")
        self.languages.append(language)


developer1 = Programmer("Batuhan", "Atabey", 5000, 3000, [
                        "Python", "Java", "C#", "PHP"])


developer1.languagesadd("GoLang")
developer1.salaryplus(50)

developer1.viewDetails()
