FROM python:3.9
WORKDIR /
ENV FLASK_APP=./api-user/main.py
ENV FLASK_RUN_HOST=0.0.0.0
ENV FLASK_RUN_PORT=5001
COPY requirements.txt requirements.txt
RUN pip install -r requirements.txt
EXPOSE 5001
COPY . /
CMD ["flask", "run"]