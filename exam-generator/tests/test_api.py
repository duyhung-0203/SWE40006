from utils.api import (
    prepare_prompt,
    sanitize_line,
    get_correct_answer,
    response_to_questions,
    get_questions,
    clarify_question
)
from model.question import Question

# TESTING prepare_prompt 
def test_prepare_prompt():
    prompt = prepare_prompt("Math", 5, 4) # topic + num question + num answer
    assert "Math" in prompt
    assert "5 questions" in prompt
    assert "4 of possible answers" in prompt
    assert "**" in prompt  # Ensuring correct answers are marked

# TESTING sanitize_line 
def test_sanitize_question_line():
    assert sanitize_line("1. What is 2+2?", True) == "What is 2+2?"

def test_sanitize_answer_line():
    assert sanitize_line("A) Four", False) == "Four"
    assert sanitize_line("b) Five", False) == "Five"

# TESTING get_correct_answer 
def test_get_correct_answer():
    answers = ["One", "**Two**", "Three", "Four"]
    assert get_correct_answer(answers) == 1  # The second option should be correct

def test_get_correct_answer_no_correct():
    answers = ["One", "Two", "Three", "Four"]
    assert get_correct_answer(answers) == -1  # No correct answer found

# TESTING response_to_questions 
def test_response_to_questions():
    mock_response = """1. What is 2+2?
A) One
B) Two
C) **Four**
D) Three"""
    questions = response_to_questions(mock_response)
    assert len(questions) == 1
    assert questions[0].question == "What is 2+2?"
    assert questions[0].answers == ["One", "Two", "Four", "Three"]
    assert questions[0].correct_answer == 2  # Index of "Four"

def test_response_to_questions_multiple():
    mock_response = """1. What is 2+2?
A) One
B) Two
C) **Four**
D) Three

2. What is the capital of France?
A) **Paris**
B) London
C) Rome
D) Madrid"""
    questions = response_to_questions(mock_response)
    assert len(questions) == 2
    assert questions[1].question == "What is the capital of France?"
    assert questions[1].answers == ["Paris", "London", "Rome", "Madrid"]
    assert questions[1].correct_answer == 0  # "Paris" is correct

# MOCKING OpenAI API
def mock_complete_text(prompt):
    return """1. What is 2+2?
A) One
B) Two
C) **Four**
D) Three"""

def test_get_questions(monkeypatch):
    monkeypatch.setattr("utils.api.complete_text", mock_complete_text)
    questions = get_questions("Math", 1, 4)
    assert len(questions) == 1
    assert questions[0].question == "What is 2+2?"
    assert "Four" in questions[0].answers
    assert questions[0].correct_answer == 2
# TESTING clarify_question 
def test_clarify_question(monkeypatch):
    # Mock response for clarify_question
    def mock_clarify_text(prompt):
        return "The correct answer is c because 2+2 equals 4."

    monkeypatch.setattr("utils.api.complete_text", mock_clarify_text)

    # Create a sample Question object
    question = Question(
        id=1,
        question="What is 2+2?",
        answers=["One", "Two", "Four", "Three"],
        correct_answer=2  # Index of "Four" (c)
    )

    # Call the function
    result = clarify_question(question)

    # Assertions
    assert isinstance(result, str)
    assert "The correct answer is c" in result
    assert "2+2 equals 4" in result