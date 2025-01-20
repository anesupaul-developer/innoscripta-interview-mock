# Project Setup and Instructions

Follow the steps below to set up and run the project locally:

1. **Clone the repository**  
   Clone the repository from the following link:  
   `git clone https://github.com/anesupaul-developer/innoscripta-interview-mock`

2. **Checkout the correct branch**  
   Run the following command to switch to the `main` branch:  
   `git checkout main`

3. **Set up environment variables**

   *Do this for both frontend/src and newsparser/src*

   Copy the `.env.example` file to `.env` and set up your environment variables:  
   `cp .env.example .env`

4. **Start the parser and app**  
   Inside the root folder containing the `Makefile`, run the following commands:  
   `make start_parser`  
   `make start_app`

5. **Open the application in your browser**  
   Navigate to `http://localhost:8081` in your browser.

6. **Produce articles**  
   Run the following command to produce articles:  
   `make produce_articles`

7. **Consume articles**  
   Run the following command to consume articles:  
   `make consume_articles`

8. **Check articles in your browser**  
   Navigate back to your browser and see the articles.

9. Demo video is on `https://youtu.be/iLiEpw9nZms`

Enjoy working with the application!
