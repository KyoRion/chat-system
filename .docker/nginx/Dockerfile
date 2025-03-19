FROM nginx:stable

WORKDIR /var/www/html

ENV DOMAIN_NAME = ${DOMAIN_NAME}
ENV TZ=Asia/Ho_Chi_Minh

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
COPY ./includes/ /etc/nginx/includes/
COPY ./nginx.conf /etc/nginx/nginx.conf

CMD ["nginx", "-g", "daemon off;"]
