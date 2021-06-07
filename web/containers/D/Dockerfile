FROM node:14
LABEL maintainer="Ganesh - Segurança da Informação"

# sudo docker build -t ganesh/container-d:1.0 .
# sudo docker run -d -p 2337:2337 --rm --name ganesh-d-instance ganesh/container-d:1.0

# Install Chromium Browsers to run puppeteer
# https://github.com/puppeteer/puppeteer/blob/main/docs/troubleshooting.md#running-puppeteer-in-docker
RUN apt-get update \
    && apt-get install -y wget gnupg \
    && wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | apt-key add - \
    && sh -c 'echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google.list' \
    && apt-get update \
    && apt-get install -y google-chrome-stable fonts-ipafont-gothic fonts-wqy-zenhei fonts-thai-tlwg fonts-kacst fonts-freefont-ttf libxss1 \
      --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*

# Copying the challenges to container
COPY challenges /challenges

# Moving the files inside the container and remove them
RUN cp -r /challenges/20_Ganesh_Travelers/src /app && \
    rm -r /challenges 

# Change the Working Dir
WORKDIR /app

# Installing the Node Packages
RUN npm install

# Expose Chall 20 Port
EXPOSE 2337

# Running the Node Server
CMD ["npm", "start"]