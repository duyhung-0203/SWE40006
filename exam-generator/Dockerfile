# exam-generator/Dockerfile
FROM python:3.11-slim

# Tạo thư mục app
WORKDIR /app

# Sao chép file requirements và cài đặt
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Sao chép toàn bộ code
COPY . .

# Expose port (nếu app chạy trên 8501 - ví dụ Streamlit)
EXPOSE 8501

# Lệnh chạy app
CMD ["streamlit run", "main.py"]
