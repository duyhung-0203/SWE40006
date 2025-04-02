import pytest
from unittest.mock import Mock
import streamlit as st
from app.page import PageEnum, GenerateExamPage, QuestionsPage, ResultsPage
from app.app import App, get_app

# Mock the imported page classes
@pytest.fixture
def mock_pages():
    mock_generate = Mock(spec=GenerateExamPage)
    mock_generate.render = Mock()  
    mock_questions = Mock(spec=QuestionsPage)
    mock_questions.render = Mock()
    mock_questions.number_of_question = 0
    mock_results = Mock(spec=ResultsPage)
    mock_results.render = Mock()
    mock_results.clarifications = {}
    
    return {
        PageEnum.GENERATE_EXAM: mock_generate,
        PageEnum.QUESTIONS: mock_questions,
        PageEnum.RESULTS: mock_results
    }

@pytest.fixture
def app(mock_pages):
    # Mock streamlit's rerun to avoid actual reruns during testing
    st.rerun = Mock()
    app_instance = App()
    app_instance.pages = mock_pages
    app_instance.current_page = mock_pages[PageEnum.GENERATE_EXAM]
    return app_instance

def test_app_initialization(mock_pages):
    app = App()
    
    assert isinstance(app.pages, dict)
    assert len(app.pages) == 3
    assert app.current_page == app.pages[PageEnum.GENERATE_EXAM]
    assert app.questions is None
    assert app._answers == {}

def test_render(app):
    app.render()
    app.current_page.render.assert_called_once_with(app)

def test_questions_property(app):
    test_questions = ["Q1", "Q2", "Q3"]
    app.questions = test_questions
    assert app.questions == test_questions

def test_add_answer(app):
    app.add_answer(0, 1)
    assert app._answers[0] == 1
    
    app.add_answer(1, 2)
    assert app._answers[1] == 2
    assert len(app._answers) == 2

def test_get_answer(app):
    # Test with no answer
    assert app.get_answer(0) is None
    
    # Test with added answer
    app.add_answer(0, 1)
    assert app.get_answer(0) == 1
    
    # Test with non-existent question
    assert app.get_answer(999) is None

def test_change_page(app):
    # Test changing to QUESTIONS page
    app.change_page(PageEnum.QUESTIONS)
    assert app.current_page == app.pages[PageEnum.QUESTIONS]
    st.rerun.assert_called_once()
    
    # Reset mock and test changing to RESULTS page
    st.rerun.reset_mock()
    app.change_page(PageEnum.RESULTS)
    assert app.current_page == app.pages[PageEnum.RESULTS]
    st.rerun.assert_called_once()

def test_reset(app):
    # Set some test data
    app.questions = ["Q1", "Q2"]
    app.add_answer(0, 1)
    app.pages[PageEnum.QUESTIONS].number_of_question = 5
    app.pages[PageEnum.RESULTS].clarifications = {"test": "data"}
    app.current_page = app.pages[PageEnum.RESULTS]
    
    # Reset and verify
    app.reset()
    
    assert app.questions is None
    assert app._answers == {}
    assert app.pages[PageEnum.QUESTIONS].number_of_question == 0
    assert app.pages[PageEnum.RESULTS].clarifications == {}
    assert app.current_page == app.pages[PageEnum.GENERATE_EXAM]
    st.rerun.assert_called_once()

def test_get_app():
    # Test that get_app returns an App instance
    app1 = get_app()
    assert isinstance(app1, App)
    
    # Test that it returns the same instance (cached)
    app2 = get_app()
    assert app1 is app2

# Clean up the cache after tests
@pytest.fixture(autouse=True)
def cleanup():
    yield
    get_app.clear()  # Clear the cache after each test

if __name__ == "__main__":
    pytest.main()