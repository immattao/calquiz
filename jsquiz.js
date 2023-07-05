//import classes from Quiz.js
import { Quiz, Question, Polynomial } from "./classes/Quiz.js";

(function() {
    // Declare variables
    let quiz = new Quiz(-1);    //-1 means inf. For now, quiz runs with unlimited length
    let scoreDiv = $('#score')  //the score div
    let quizDiv = $('#quiz');   //the quiz div
    let answer;                 //the user answer

    // Reset score and hide all buttons except 'start'
    changeScoreDiv(0);
    $('#next').hide();
    $('#quit').hide();

    // Click handler for the 'next' button
    $('#next').on('click', function (e) {
        e.preventDefault();
        
        // Suspend click listener during fade animation
        if(quizDiv.is(':animated')) {        
            return false;
        }

        getInput();

        // If no input, progress is stopped, else submit
        if (answer == '') {
            alert('Please make an answer!');
        } else {

            // Check answer & increment score if need be; if wrong, show answer  
            if (quiz.isCorrect(answer)) {
                $('#answer').remove(); //remove answer from previous wrong question 
            } else {
                showAns();
            }

            // Update questionCounter and score in the UI, and continue
            changeScoreDiv(quiz.score); 
            displayNext();
        }
    });

    // Click handler for the 'quit' button
    $('#quit').on('click', function (e) {
        e.preventDefault();
        
        if(quizDiv.is(':animated')) {
            return false;
        }

        $('#answer').remove();

        quiz.toDatabase();

        // TODO: Implement variable question number
        // questionNum = -1;

        // Continue
        displayNext();
    });
      
    // Click handler for the 'Start Over' button
    $('#start').on('click', function (e) {
        e.preventDefault();
        
        if(quizDiv.is(':animated')) {
            return false;
        }

        $('#answer').remove();

        // Reset all values, and continue 
        quiz = new Quiz(-1); //MOVED //TODO: implement quiz length
        answer = '';
        changeScoreDiv(0);
        displayNext();
        
        // Hide start button, shows all others
        $('#next').show();
        $('#quit').show();
        $('#start').hide();
    });

    // Get user answer input
    function getInput() {
        answer = $('input[name="answer"]').val();
    }

    // Update score div to correct score
    function changeScoreDiv(score) {
        // Remove old score element
        $('#scoreNumber').remove();

        // Create new score element with new score
        var scoreNum = $('<div>', {id: 'scoreNumber'});
        var scoreString = $('<h3> Score: ' + score + '/' + quiz.questionCounter + '</h3>');
        scoreNum.append(scoreString);
        scoreDiv.append(scoreNum);
    }

    // Show the answer
    function showAns() {
        // Remove old answer element
        $('#answer').remove();

        // Create new answer element for current question
        var answerDiv = $('<div>', {id: 'answer'});
        var questionString = $('<h3> Question: ' + quiz.question.displayPoly() + '</h3>'); //TODO DONE-ISH?
        var ansString = $('<h3> Answer: ' + quiz.question.displayAns() + '</h3>'); //TODO DONE-ISH?
        answerDiv.append(questionString);
        answerDiv.append(ansString);
        scoreDiv.append(answerDiv);
    }

    // Display next question, or end quiz
    function displayNext() {

        // Set to fade out then switches questions or end quiz
        quizDiv.fadeOut(function() {
            // Remove old question element
            $('#question').remove();

            // If quiz not done 
            if (!quiz.isDone()) {
                // Create new question element
                var nextQuestion = $('<div>', {id: 'question'});
                var polyString = $('<h2>' + quiz.displayNextQuestion() + '</h2>'); //DONE
                nextQuestion.append(polyString);
                nextQuestion.append('<input name="answer" type="text"/>');

                // Show next question
                quizDiv.append(nextQuestion).fadeIn();
                
            } else {
                // If quiz done, hide all buttons, show 'start'
                $('#next').hide();
                $('#quit').hide();
                $('#start').show();
            }
        });
    }
})();

