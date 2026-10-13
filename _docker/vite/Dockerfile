FROM node:22


WORKDIR /var/www

COPY package*.json ./


RUN ls -la && cat package.json
RUN npm install

COPY . .

# Открываем порт
EXPOSE 5173

CMD ["npm", "run", "dev"]


