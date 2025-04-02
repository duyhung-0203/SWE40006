import pytest
from unittest.mock import Mock, patch, mock_open
import os
import subprocess
from utils.generate_document import questions_to_markdown, markdown_to_pdf, questions_to_pdf, TEMP_MD_FILE, TEMP_PDF_FILE
from model.question import Question

# Mock Question class for testing
@pytest.fixture
def mock_question():
    question = Mock(spec=Question)
    question.question = "What is 2+2?"
    question.answers = ["2", "4", "6", "8"]
    return question

@pytest.fixture
def mock_questions(mock_question):
    return [mock_question, mock_question]  # Two identical questions for testing

def test_questions_to_markdown(mock_questions):
    # Test the conversion of questions to markdown
    result = questions_to_markdown(mock_questions)
    
    expected = (
        "**1. What is 2+2?**\n\n"
        "- [ ] 2\n"
        "- [ ] 4\n"
        "- [ ] 6\n"
        "- [ ] 8\n\n"
        "**2. What is 2+2?**\n\n"
        "- [ ] 2\n"
        "- [ ] 4\n"
        "- [ ] 6\n"
        "- [ ] 8\n\n"
    )
    
    assert result == expected

def test_questions_to_markdown_empty_list():
    # Test with an empty list of questions
    result = questions_to_markdown([])
    assert result == ""

@patch("builtins.open", new_callable=mock_open)
@patch("subprocess.run")
@patch("os.remove")
def test_markdown_to_pdf(mock_remove, mock_subprocess, mock_file):
    # Test markdown to PDF conversion
    markdown_content = "**Test Question**\n\n- [ ] Answer"
    output_file = "test_output.pdf"
    
    markdown_to_pdf(markdown_content, output_file)
    
    # Verify file was opened and written to
    mock_file.assert_called_once_with(TEMP_MD_FILE, "w", encoding="utf-8")
    handle = mock_file()
    handle.write.assert_called_once_with(markdown_content)
    
    # Verify subprocess call
    mock_subprocess.assert_called_once_with([
        "mdpdf", TEMP_MD_FILE,
        "--output", output_file,
        "--footer", ",,{page}",
        "--paper", "A4"
    ])
    
    # Verify temporary file was removed
    mock_remove.assert_called_once_with(TEMP_MD_FILE)

@patch("utils.generate_document.markdown_to_pdf")
@patch("utils.generate_document.questions_to_markdown")
def test_questions_to_pdf(mock_questions_to_markdown, mock_markdown_to_pdf, mock_questions):
    # Test the full questions to PDF pipeline
    output_file = "output.pdf"
    mock_markdown_content = "**Mock Markdown**"
    mock_questions_to_markdown.return_value = mock_markdown_content
    
    questions_to_pdf(mock_questions, output_file)
    
    # Verify the pipeline calls
    mock_questions_to_markdown.assert_called_once_with(mock_questions)
    mock_markdown_to_pdf.assert_called_once_with(mock_markdown_content, output_file)

if __name__ == "__main__":
    pytest.main()