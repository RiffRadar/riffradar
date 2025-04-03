FROM node:18

WORKDIR /var/www/html/frontend

COPY frontend/package.json frontend/package-lock.json ./

RUN npm install

RUN npm install -g nodemon

COPY frontend .

RUN npm run build

EXPOSE 3000

CMD ["nodemon", "-L", "--watch", ".", "--exec", "npm", "run", "dev"]