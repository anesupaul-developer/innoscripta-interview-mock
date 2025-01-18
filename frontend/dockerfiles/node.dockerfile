FROM node:current-alpine

RUN mkdir -p /var/www/html

WORKDIR /var/www/html

RUN npm install -g npm@latest

EXPOSE 3000

CMD ["npm", "start"]