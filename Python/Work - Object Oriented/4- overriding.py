class Worker():

    def __init__(self, name, salary, department):
        print("Worker Status")
        self.name = name
        self.salary = salary
        self.department = department

    def viewDetails(self):
        print("Worker Details")
        print(" Name : {} \n Salary: {} \n Department {} ".format(
            self.name, self.salary, self.department))

    def departmantChange(self, newDepartman):
        self.department = newDepartman


class Manager(Worker):
    def __init__(self, name, salary, department, numberpeople):
        # SUPER  : take data parent
        super().__init__(name, salary, department)
        self.numberpeople = numberpeople

    def viewDetails(self):
        print("Worker Details")
        print(" Name : {} \n Salary: {} \n Department {} \n Number People: {}".format(
            self.name, self.salary, self.department, self.numberpeople))

    def pluss_salary(self, number):
        self.salary += number


manager1 = Manager("Batuhan Atabey", 3000, "Python Developer", 5)

manager1.viewDetails()
