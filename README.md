Here is a Howitzer Game application as my sample code.
How it works : You pick a user, weight of howitzer, distance of target, size of the target, speed, angle of shot and you fire.
The results are saved in the database and a stats are processed against that.

Demo: http://ec2-52-90-251-194.compute-1.amazonaws.com/public/

***API DOC:***
----

**Show Multiple user**
----
  Returns json data about a multiple users.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/users

* **Method:**

  `GET`
  
*  **URL Params**

  None

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"user": [{"id":"1","name":"user_1"},{"id":"2","name":"user_2"}]}`


**Show Single User**
----
  Returns json data about a single user.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/users/:id

* **Method:**

  `GET`
  
*  **URL Params**

   **Required:**
 
   `id=[integer]`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{ id : 12, name : "Michael Bloom" }`


**Create User**
----
  Returns json data about user ID.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/users

* **Method:**

  `POST`
  
*  **URL Params**

   None

* **Data Params**

    **Required:**
 
   `name=[alpha numeric]`

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{user_id: 12}`


**Get List howitzer**
----
  Returns json data about a multiple howitzers.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/howitzers

* **Method:**

  `GET`
  
*  **URL Params**

  None

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"howitzer": [{"id":"1","weight":"1000"},{"id":"2","weight":"2000"}]}`



**Show Single Howitzer**
----
  Returns json data about a single howitzer.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/howitzers/:id

* **Method:**

  `GET`
  
*  **URL Params**

   **Required:**
 
   `id=[integer]`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"howitzer": {"id":"1","weight":"1000"}}`



**Create Howitzer**
----
  Returns json data about a howitzer ID.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/howitzers

* **Method:**

  `POST`
  
*  **URL Params**

   None

* **Data Params**

  **Required:**
 
   `id=[alphanumeric]`

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"howitzer_id": 13}`



**Show List Distance**
----
  Returns json data about a multiple distances.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/distances

* **Method:**

  `GET`
  
*  **URL Params**

  None

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"distance": [{"id":"1","distance":"100"},{"id":"2","distance":"200"}]}`



**Show Single Distance**
----
  Returns json data about a single distance.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/distances/:id

* **Method:**

  `GET`
  
*  **URL Params**

  **Required:**
 
  `id=[integer]`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"howitzer": {id: 14, distance: 1000}}`
 

**Create Distance**
----
  Returns json data about a distance ID.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/distances

* **Method:**

  `POST`
  
*  **URL Params**

   None

* **Data Params**

  **Required:**
 
   `distance=[integer]`

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"distance_id": 16}`



**Show List Target**
----
  Returns json data about a multiple targets.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/targets

* **Method:**

  `GET`
  
*  **URL Params**

  None

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"target": [{"id":"1","size":"10"},{"id":"2","size":"20"}]}`
 


**Show Single Target**
----
  Returns json data about a single target.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/targets/:id

* **Method:**

  `GET`
  
*  **URL Params**

  **Required:**
 
  `id=[integer]`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"target": {id: 14, size: 30}}`
 


**Create Target**
----
  Returns json data about a target ID.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/targets

* **Method:**

  `POST`
  
*  **URL Params**

   None

* **Data Params**

  **Required:**
 
   `size=[integer]`

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"target_id": 17}`


**Show List Speed**
----
  Returns json data about a multiple speeds.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/speeds

* **Method:**

  `GET`
  
*  **URL Params**

  None

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"target": [{"id":"1","speed":"15"},{"id":"2","speed":"25"}]}`
 


**Show Single Speed**
----
  Returns json data about a single speed.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/speeds/:id

* **Method:**

  `GET`
  
*  **URL Params**

  **Required:**
 
  `id=[integer]`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"speed": {id: 14, speed: 30}}`
 


**Create Speed**
----------------
  Returns json data about a speed ID.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/speeds

* **Method:**

  `POST`
  
*  **URL Params**

   None

* **Data Params**

  **Required:**
 
   `speed=[integer]`

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"speed_id": 17}`



**Show List Angle**
-------------------
  Returns json data about a multiple angles.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/angles

* **Method:**

  `GET`
  
*  **URL Params**

  None

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"angle": [{"id":"1","angle":"15"},{"id":"2","angle":"25"}]}`



**Show Single Angle**
---------------------
  Returns json data about a single angle.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/angles/:id

* **Method:**

  `GET`
  
*  **URL Params**

  **Required:**
 
  `id=[integer]`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"angle": {id: 14, angle: 30}}`
 


**Create Angle**
----------------
  Returns json data about a angle ID.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/angles

* **Method:**

  `POST`
  
*  **URL Params**

   None

* **Data Params**

  **Required:**
 
   `angle=[integer]`

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"angle_id": 18}`



**Show List Shot**
------------------
  Returns json data about a multiple shots.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/shots

* **Method:**

  `GET`
  
*  **URL Params**

  None

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"shot": [{"id":"1","user":{"id":"1","name":"user_1"},"howitzer":{"id":"1","weight":"1000"},"target":{"id":"1","size":"10"},"distance":{"id":"1","distance":"100"},"speed":{"id":"1","speed":"5"},"angle":{"id":"1","angle":"5"}},{"id":"21","user":{"id":"1","name":"user_1"},"howitzer":{"id":"1","weight":"1000"},"target":{"id":"1","size":"10"},"distance":{"id":"1","distance":"100"},"speed":{"id":"1","speed":"5"},"angle":{"id":"5","angle":"25"}}]}`
 


**Show Single Shot**
--------------------
  Returns json data about a single shot.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/shots/:id

* **Method:**

  `GET`
  
*  **URL Params**

  **Required:**
 
  `id=[integer]`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"shot": {"id":"1","user":{"id":"1","name":"user_1"},"howitzer":{"id":"1","weight":"1000"},"target":{"id":"1","size":"10"},"distance":{"id":"1","distance":"100"},"speed":{"id":"1","speed":"5"},"angle":{"id":"1","angle":"5"}}}`


**Create Shot**
---------------
  Returns json data about a shot ID.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/shots

* **Method:**

  `POST`
  
*  **URL Params**

   None

* **Data Params**

  **Required:**
 
   `angle_id=[integer],
   howitzer_id=[integer],
   target_id=[integer],
   distance_id=[integer],
   speed_id=[integer],
   user_id=[integer]`

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"shot_id": 19}`



**Show List Result**
--------------------
  Returns json data about a multiple results.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/results

* **Method:**

  `GET`
  
*  **URL Params**

  None

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"shot": [{"id":"1","user":{"id":"1","name":"user_1"},"shot":{"howitzer":{"id":"1","name":"1000"},"target":{"id":"1","size":"10"},"distance":{"id":"1","distance":"100"},"speed":{"id":"1","speed":"5"},"angle":{"id":"1","angle":"5"}},"hit":"1","impact":"0"},{"id":"2","user":{"id":"1","name":"user_1"},"shot":{"howitzer":{"id":"1","name":"1000"},"target":{"id":"1","size":"10"},"distance":{"id":"1","distance":"100"},"speed":{"id":"1","speed":"5"},"angle":{"id":"1","angle":"5"}},"hit":"1","impact":"0"}]}`



**Show Single Result**
----------------------
  Returns json data about a single shot.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/results/:id

* **Method:**

  `GET`
  
*  **URL Params**

  **Required:**
 
  `id=[integer]`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"result": {"id":"1","user":{"id":"1","name":"user_1"},"shot":{"howitzer":{"id":"1","name":"1000"},"target":{"id":"1","size":"10"},"distance":{"id":"1","distance":"100"},"speed":{"id":"1","speed":"5"},"angle":{"id":"1","angle":"5"}},"hit":"1","impact":"0"}}`
 


**Create Result**
-----------------
  Returns json data about a result ID.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/results

* **Method:**

  `POST`
  
*  **URL Params**

   None

* **Data Params**

  **Required:**
 
   `user_id=[integer],
   shot_id=[integer],
   hit=[integer],
   impact=[integer]

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"result_id": 19}`
 


**Show List Top Best Shotters**
-------------------------------
  Returns json data about a Top Best Shotters.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/top/:limit

* **Method:**

  `GET`
  
*  **URL Params**

  limit=[integer]

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"top": [{"user":{"id":"1","name":"user_1"},"hits":"4","avg-closed-target":"88.8800"},{"user":{"id":"5","name":"user_5"},"hits":"0","avg-closed-target":"282.0000"}]}`
 


**Show Total Shots**
--------------------
  Returns json data about a total shotters.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/shots-total

* **Method:**

  `GET`
  
*  **URL Params**

  None

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"total": 31}`
 


**Show Total Users**
--------------------
  Returns json data about a Total users.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/users-total

* **Method:**

  `GET`
  
*  **URL Params**

  None

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"total": 31}`



**Show Average Shot**
---------------------
  Returns json data about average shot.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/shots-avg

* **Method:**

  `GET`
  
*  **URL Params**

  None

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"avg": 2.88}`


**Show Ranking by User**
------------------------
  Returns json data about ranking by user.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/ranking

* **Method:**

  `GET`
  
*  **URL Params**

  None

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"ranking": [{"user":{"id":"1","name":"user_1"},"hits":"4"}]}`


**Show Total Shots by User**
----------------------------
  Returns json data about total shots by user.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/shots-total-by-user/:id

* **Method:**

  `GET`
  
*  **URL Params**

  `id=[integer]`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"total": 25}`


**Show Calculate Impact on Target**
----
  Returns json data about calculate impact on target.

* **URL**

  http://ec2-52-90-251-194.compute-1.amazonaws.com/calculate-trajectoire/:id

* **Method:**

  `GET`
  
*  **URL Params**

  `id=[integer]`

* **Data Params**

  None

* **Success Response:**

  * **Code:** 200 <br />
    **Content:** `{"impact":101.38639426832,"user_id":"1","shot_id":"1","hit":0}`