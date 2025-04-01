import pytest
from unittest.mock import MagicMock, patch, mock_open
from app.page import GenerateExamPage, QuestionsPage, ResultsPage, PageEnum

# TESTING exam page rendering 
def test_generate_exam_page_render():
    app_mock = MagicMock()
    app_mock.questions = None
    page = GenerateExamPage()

    mock_questions = [
        MagicMock(question="Q1", answers=["A", "B", "C"], correct_answer=1),
        MagicMock(question="Q2", answers=["X", "Y", "Z"], correct_answer=2)
    ]

    with patch("streamlit.title") as mock_title, \
         patch("streamlit.markdown") as mock_markdown, \
         patch("streamlit.text_input", return_value="Math, Science") as mock_text_input, \
         patch("streamlit.number_input", side_effect=[10, 4]) as mock_number_input, \
         patch("streamlit.button", side_effect=[True, False]) as mock_button, \
         patch("streamlit.warning") as mock_warning, \
         patch("streamlit.info") as mock_info, \
         patch("streamlit.columns") as mock_columns, \
         patch("streamlit.download_button") as mock_download, \
         patch("app.page.get_questions", return_value=mock_questions) as mock_get_questions, \
         patch("app.page.questions_to_pdf") as mock_pdf, \
         patch("builtins.open", mock_open(read_data=b"pdf content")):

        left_col, center_col, right_col = MagicMock(), MagicMock(), MagicMock()
        mock_columns.return_value = [left_col, center_col, right_col]

        page.render(app_mock)
        # MOCK genrate exam 
        mock_title.assert_called_once_with("Generate exam")
        mock_markdown.assert_called_once_with(page.description)
        mock_text_input.assert_called_once()
        assert mock_number_input.call_count == 2
        # MOCK generate questions 
        mock_warning.assert_called_once_with("Generating questions. This may take a while...")
        mock_get_questions.assert_called_once_with("Math, Science", 10, 4)
        assert app_mock.questions == mock_questions
        # MOCK download to pdf
        mock_info.assert_called_once()
        mock_pdf.assert_called_once_with(mock_questions, "questions.pdf")

# TESTING start page of exam 
def test_generate_exam_page_start_exam():
    app_mock = MagicMock()
    mock_questions = [MagicMock(), MagicMock()]
    app_mock.questions = mock_questions
    page = GenerateExamPage()

    with patch("streamlit.title"), \
         patch("streamlit.markdown"), \
         patch("streamlit.text_input", return_value="Math, Science"), \
         patch("streamlit.number_input", side_effect=[10, 4]), \
         patch("streamlit.button", side_effect=[False, True]) as mock_button, \
         patch("streamlit.info"), \
         patch("streamlit.columns") as mock_columns, \
         patch("app.page.questions_to_pdf"), \
         patch("builtins.open", mock_open(read_data=b"pdf content")):

        left_col, center_col, right_col = MagicMock(), MagicMock(), MagicMock()
        mock_columns.return_value = [left_col, center_col, right_col]
        
        page.render(app_mock)
        
        app_mock.change_page.assert_called_once_with(PageEnum.QUESTIONS)

# TESTING page navigation 
def test_questions_page_navigation():
    app_mock = MagicMock()
    app_mock.questions = [
        MagicMock(id=1, question="Q1", answers=["A", "B", "C"], correct_answer=0),
        MagicMock(id=2, question="Q2", answers=["X", "Y", "Z"], correct_answer=1)
    ]
    app_mock.get_answer.return_value = 0
    app_mock.add_answer = MagicMock()

    page = QuestionsPage()
    page.number_of_question = 0

    with patch("app.page.st.title"), \
         patch("app.page.st.write"), \
         patch("app.page.st.radio", return_value="A"), \
         patch("app.page.st.button") as mock_button, \
         patch("app.page.st.columns") as mock_columns, \
         patch("app.page.st.rerun") as mock_rerun:

        left_col, center_col, right_col = MagicMock(), MagicMock(), MagicMock()
        mock_columns.return_value = [left_col, center_col, right_col]
        
        mock_button.side_effect = [False, True]  # Finish=False, Next=True
        
        page.render(app_mock)

        assert page.number_of_question == 1
        mock_rerun.assert_called_once()


def test_results_page_render():
    app_mock = MagicMock()
    app_mock.questions = [
        MagicMock(id=1, question="What is 2+2?", answers=["3", "4", "5"], correct_answer=1),
        MagicMock(id=2, question="Capital of France?", answers=["London", "Paris", "Berlin"], correct_answer=1)
    ]
    
    
    app_mock.get_answer.side_effect = [1, 0, 1, 0]  # Values repeated for each question
    
    app_mock.reset = MagicMock()
    app_mock.change_page = MagicMock()

    page = ResultsPage()

    
    button_responses = {
        "Generate new exam": True,  # User clicks "Generate new exam"
        "clarify_question_1": True,  # User clicks clarify for first question
        "clarify_question_2": False  # User doesn't click clarify for second question
    }

    def mock_button_side_effect(label, **kwargs):
        # Handle both positional and keyword arguments
        button_key = kwargs.get('key', label)
        return button_responses.get(button_key, False)

    with patch("streamlit.title") as mock_title, \
         patch("streamlit.write") as mock_write, \
         patch("streamlit.button", side_effect=mock_button_side_effect) as mock_button, \
         patch("streamlit.columns") as mock_columns, \
         patch("streamlit.download_button") as mock_download, \
         patch("streamlit.warning") as mock_warning, \
         patch("app.page.clarify_question", return_value="2+2 is 4") as mock_clarify, \
         patch("app.page.questions_to_pdf") as mock_pdf, \
         patch("builtins.open", mock_open(read_data=b"pdf_content")):

        # Mock columns for layout
        left_col, right_col = MagicMock(), MagicMock()
        mock_columns.return_value = [left_col, right_col]
        
        page.render(app_mock)

        # Verify title and scoring
        mock_title.assert_called_once_with("Results")
        mock_write.assert_any_call("### Number of questions: 2")
        mock_write.assert_any_call("### Number of correct answers: 1")
        mock_write.assert_any_call("### Percentage of correct answers: 50.00%")

        # Verify question rendering
        mock_write.assert_any_call("**1. What is 2+2?**")
        mock_write.assert_any_call(":green[b) 4]")  # Correct answer for Q1
        
        mock_write.assert_any_call("**2. Capital of France?**")
        mock_write.assert_any_call(":red[a) London]")     # User's incorrect answer
        mock_write.assert_any_call(":green[b) Paris]")    # Correct answer
        
        # Verify clarification functionality
        mock_clarify.assert_called_once_with(app_mock.questions[0])
        mock_write.assert_any_call("2+2 is 4")
        assert 1 in page.clarifications  # Verify it was stored
        assert 2 not in page.clarifications  # Verify second question wasn't clarified
        
        # Verify app reset and page change
        app_mock.reset.assert_called_once()
        app_mock.change_page.assert_called_once_with(PageEnum.GENERATE_EXAM)
        
        # Verify PDF export
        mock_pdf.assert_called_once_with(app_mock.questions, "questions.pdf")
        mock_download.assert_called_once()