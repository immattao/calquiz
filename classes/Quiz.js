export class Quiz 
{
    question;

    score;
    
    length;

    questionCounter;


    constructor(length){
        this.length = length;
        this.score = 0;
        this.questionCounter = 0;
        this.question = new Polynomial();
    }
    displayNextQuestion(){
        this.question = new Polynomial();
        return this.question.displayPoly();
    }
    // displayQuizQuestion(index){
    //     return this.questions[index].displayPoly();
    //     //return a string representation of the polynomial question
    // }

    isCorrect(answer){
        this.questionCounter++; 
        if(this.question.checkAnswer(answer)){
            this.score++;
            return true;
        }
        return false;
    }

    /* Check if quiz is finished (if questionNum is set,
    * automatically skipped if questionNum == -1)
    * since questionCounter is always positive;
    */
    isDone(){
        return(this.questionCounter == this.length);
    }

    // Submit score to database
    toDatabase(){
        if (this.length == -1){ //TOMOVE
            $.post("quiz-quit.php",
                {
                    score: this.score,
                    length: this.questionCounter
                });
        } else { //TOMOVE
            $.post("quiz-quit.php",
                {
                    score: score,
                    length: this.length
                });
        }
        // Quiz is finished, set counter to complete
        this.questionCounter = this.length; //TOMOVE
    }
}

export class Question
{
    //function to generate random interger
    rand(min, max) {
        return Math.floor(Math.random() * (max - min) ) + min;
    }
}

export class Polynomial extends Question
{
    //the polynomial is stored as an array
    polynomial = [];

    //the differented polynomial
    diff_poly = [];

    //generate a random degree 
    degree = super.rand(1, 10);

    constructor(){
        super();
        this.generateQuestion();
        this.generateAnswer();
    }

    generateQuestion(){
        //fill in the array items with default values = 0
        for(let i = 0; i <= this.degree; i++){
            this.polynomial.push(0);
        }

        //generate number of terms in the polynomial
        const numberOfTerms = super.rand(1, this.degree);

        //generate coeff of the term with highest degree
        this.polynomial[this.degree] = super.rand(1, 10);

        //generate coeffs of the other terms (we already got 1 term)
        let counter = 1;
        let index;
        while(counter < numberOfTerms){
            do {
                //for a random index
                index = super.rand(1, this.degree-1);
            } 
            //check if there's already a value 
            while(this.polynomial[index]!=0);
            //if not, generate a value from 1-10 to be the coefficient of the term
            this.polynomial[index] = super.rand(1, 10);
            counter++;
        }
    }

    generateAnswer(){
        //differentiation, power rule
        for(let i = 0; i <= this.degree-1; i++){
            this.diff_poly.push((i+1)*this.polynomial[i+1]);
        }
    }
    toString(poly, degree){
        let polyString = "";

        //display the polynomial. the i var of a term is the degree of that term
        for(let i = degree; i >= 0; i--){

            //only display the term if the coefficient is not 0
            if(poly[i]==0){
                continue;
            }   

            //add coefficient if not 1 or if degree = 0
            if(poly[i]!=1 || i==0){
                polyString = polyString.concat(poly[i]);
            }

            //add x if the index (power) is not 0
            if(i != 0){
                polyString = polyString.concat('x');
            }

            //add ^[i] if the index (power) is above 1
            if(i > 1){
                polyString = polyString.concat('^',i);
            }

            polyString = polyString.concat(' + ');
        }

        //remove last "+" sign (by removing last 3 characters ' + ')
        polyString = polyString.slice(0,-3);

        return polyString;
    } 

    displayPoly(){
        let string = this.toString(this.polynomial, this.degree);
        return string;
    }
    displayAns(){
        let string = this.toString(this.diff_poly, this.degree-1);
        return string;
    }
    checkAnswer(userAnswer){
        if(userAnswer == this.displayAns()){
            return true;
        }
        else return false;
    }
}





