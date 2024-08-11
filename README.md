
# API Endpoints

### Headers
- `Accept: application/json`
- `Authorization: Bearer {token}`


### Register a User

- **Method:** `POST`
- **URL:** `http://127.0.0.1:8000/api/register`
- **Request Body:**
  ```json
  {
    "name": "Anagha",
    "email": "anagha@gmail.com",
    "password": "1234"
  }


Login a User

Method: POST
URL: http://127.0.0.1:8000/api/login
Request Body:
{
  "email": "user@gmail.com",
  "password": "1234"
}


Logout a User

Method: POST
URL: http://127.0.0.1:8000/api/logout


Jobs List

Method: GET
URL: http://127.0.0.1:8000/api/jobs


Create a Job

Method: POST
URL: http://127.0.0.1:8000/api/jobs
Request Body:
{
  "title": "Web Developer",
  "description": "Experienced Web Developer",
  "company": "Ab Tech",
  "location": "Kochi",
  "salary": 50000
}


Here's a single note with the headers included at the top:

markdown
Copy code
# API Endpoints

### Headers
- `Accept: application/json`
- `Authorization: Bearer {token}`

### Register a User
- **Method:** `POST`
- **URL:** `http://127.0.0.1:8000/api/register`
- **Request Body:**
  ```json
  {
    "name": "Anagha",
    "email": "anagha@gmail.com",
    "password": "1234"
  }
Login a User
Method: POST
URL: http://127.0.0.1:8000/api/login
Request Body:
json
Copy code
{
  "email": "abid@gmail.com",
  "password": "1234"
}
Logout a User
Method: POST
URL: http://127.0.0.1:8000/api/logout
Jobs List
Method: GET
URL: http://127.0.0.1:8000/api/jobs
Create a Job
Method: POST
URL: http://127.0.0.1:8000/api/jobs
Request Body:
json
Copy code
{
  "title": "Web Developer",
  "description": "Experienced Web Developer",
  "company": "Ab Tech",
  "location": "Kochi",
  "salary": 50000
}


Job Details

Method: GET
URL: http://127.0.0.1:8000/api/jobs/1


Update a Job

Method: PUT or PATCH
URL: http://127.0.0.1:8000/api/jobs/1
Request Body;
{
  "title": "Web Developer",
  "description": "Experienced Web Developer",
  "company": "Ab Tech",
  "location": "Kochi",
  "salary": 50000
}


Delete a Job

Method: DELETE
URL: http://127.0.0.1:8000/api/jobs/1


Apply for a Job

Method: POST
URL: http://127.0.0.1:8000/api/job/applications
Request Body:
{
  "job_post_id": 2
}


List of Applied Jobs (By User)

Method: GET
URL: http://127.0.0.1:8000/api/job/applied


List of Applicants for a Job (For Job Poster)

Method: GET
URL: http://127.0.0.1:8000/api/job/applicants
