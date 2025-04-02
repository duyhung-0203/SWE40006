from typing import List
import openai
import re

from model.question import Question

MODEL = "gpt-4o-mini"


def complete_text(prompt: str) -> str:
    """
    Complete text using GPT-4 Turbo
    :param prompt: Prompt to complete
    :return: Completed text
    """
    messages = [{"role": "user", "content": prompt}]
    return openai.ChatCompletion.create(model=MODEL, messages=messages)["choices"][0]["message"]["content"]


def prepare_prompt(topics: str, number_of_questions: int, number_of_answers: int) -> str:
    """
    Prepare prompt to complete
    :param topics: Topics to include in the exam
    :param number_of_questions: Number of questions
    :param number_of_answers: Number of answers
    :return: Prompt to complete
    """
    return (
        f"Create an exam of multiple choice questions with {number_of_questions} "
        f"questions and {number_of_answers} of possible answers in each question. "
        f"Put the correct answer in bold (surrounded by **) in its original spot. "
        f"The exam should be about {topics}. Only generate the questions and "
        f"answers, not the exam itself."
    )


def sanitize_line(line: str, is_question: bool) -> str:
    """
    Sanitize a line from the response
    :param line: Line to sanitize
    :param is_question: Whether the line is a question or an answer
    :return: Sanitized line
    """
    # Loại bỏ khoảng trắng đầu/cuối
    line = line.strip()
    if is_question:
        # Loại bỏ các số đầu dòng, dấu chấm và khoảng trắng (ví dụ: "1. " hoặc "  2. ")
        new_line = re.sub(r"^[0-9]+\.\s*", "", line)
    else:
        # Loại bỏ ký tự đầu dòng như "A) ", "b) ", "C. " (không phân biệt chữ hoa/thường)
        new_line = re.sub(r"^[a-eA-E][).]\s*", "", line)
    return new_line.strip()


def get_correct_answer(answers: List[str]) -> int:
    """
    Return the index of the correct answer
    :param answers: List of answers
    :return: Index of the correct answer if found, -1 otherwise
    """
    for index, answer in enumerate(answers):
        if "**" in answer:
            return index
    return -1


def response_to_questions(response: str) -> List[Question]:
    """
    Convert the response from the API to a list of questions
    :param response: Response to convert
    :return: List of questions
    """
    questions = []
    count = 1

    for question_text in response.split("\n\n"):
        question_text = question_text.strip()
        if not question_text:
            continue

        question_lines = question_text.splitlines()

        # Lấy câu hỏi đã được làm sạch
        question = sanitize_line(question_lines[0], is_question=True)
        # Xử lý các dòng đáp án
        answers = list(map(lambda line: sanitize_line(line, is_question=False), question_lines[1:]))

        correct_answer = get_correct_answer(answers)
        if correct_answer >= 0:
            answers[correct_answer] = answers[correct_answer].replace("**", "")

        answers = list(map(lambda answer: answer.strip(), answers))

        questions.append(Question(count, question, answers, correct_answer))
        count += 1

    return questions


def get_questions(topics: str, number_of_questions: int, number_of_answers: int) -> List[Question]:
    """
    Get questions from OpenAI API
    :param topics: Topics to include in the exam
    :param number_of_questions: Number of questions
    :param number_of_answers: Number of answers
    :return: List of questions
    """
    prompt = prepare_prompt(topics, number_of_questions, number_of_answers)
    response = complete_text(prompt)
    return response_to_questions(response)


def clarify_question(question: Question) -> str:
    """
    Clarify a question using GPT-4 Turbo
    :param question: Question to clarify
    :return: Text clarifying the question
    """
    join_questions = "\n".join([f"{chr(ord('a') + i)}. {answer}" for i, answer in enumerate(question.answers)])
    prompt = f"Given this question: {question.question}\n"
    prompt += f" and these answers: {join_questions}\n\n"
    prompt += f"Why the correct answer is {chr(ord('a') + question.correct_answer)}?\n\n"
    return complete_text(prompt)
