FROM python:3.7
ENV PYTHONUNBUFFERED 1
ENV WORK_DIR /work

RUN mkdir ${WORK_DIR}
WORKDIR ${WORK_DIR}

ADD requirements.txt ${WORK_DIR}

RUN pip3 install -r requirements.txt
ADD . ${WORK_DIR}

EXPOSE 8000
