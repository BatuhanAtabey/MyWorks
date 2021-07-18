class  Worker():

    def __init__(self, name, salary,department):
        print("Worker Status")
        self.name = name
        self.salary = salary
        self.department = department
    
    def viewDetails(self):
        print("Worker Details")
        print(" Name : {} \n Salary: {} \n Department {} ".format(self.name,self.salary,self.department))
    
    def departmantChange(self,newDepartman):
        self.department = newDepartman


class Manager(Worker):
    def pluss_salary(self,number):
        self.salary += number


manager1 = Manager("Batuhan Atabey",3000,"Developer")

manager1.viewDetails()

manager1.departmantChange("Computer Engineer")
manager1.pluss_salary(500)

manager1.viewDetails()

print (dir(Manager))