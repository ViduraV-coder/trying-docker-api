FROM python:3.9
WORKDIR /
ENV FLASK_APP=./api-admin/main.py
ENV FLASK_RUN_HOST=0.0.0.0
ENV FLASK_RUN_PORT=6000
COPY requirements.txt requirements.txt
RUN pip install -r requirements.txt
EXPOSE 6000
COPY . /
CMD ["flask", "run"]