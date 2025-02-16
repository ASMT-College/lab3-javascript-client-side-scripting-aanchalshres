//User-Defined Objects in JavaScript
//using literal 
let person = {
    firstName: "John",
    lastName: "Doe",
    age: 25,
    fullName: function() {
        return this.firstName + " " + this.lastName;
    }
};

console.log(person.firstName); // John
console.log(person.fullName()); // John Doe

// Using new Object() Constructor
let car = new Object();
car.brand = "Toyota";
car.model = "Corolla";
car.year = 2022;

console.log(car.brand); // Toyota

//Using Constructor Function
function Student(name, age, course) {
    this.name = name;
    this.age = age;
    this.course = course;
    this.getDetails = function() {
        return `${this.name} is ${this.age} years old and studies ${this.course}.`;
    };
}

let student1 = new Student("Alice", 22, "Computer Science");
console.log(student1.getDetails()); // Alice is 22 years old and studies Computer Science.


//Using ES6 Classes (Modern Approach)
class Employee {
    constructor(name, position, salary) {
        this.name = name;
        this.position = position;
        this.salary = salary;
    }

    getInfo() {
        return `${this.name} works as a ${this.position} earning $${this.salary}.`;
    }
}

let emp1 = new Employee("David", "Software Engineer", 60000);
console.log(emp1.getInfo()); // David works as a Software Engineer earning $60000.

