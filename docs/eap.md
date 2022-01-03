# EAP: Architecture Specification and Prototype

## A7: Web Resources Specification

This artefact presents the documentation for the Bright Events web application, including the catalogue of available resources. Each resource is detailed, regarding its properties, such as input and response format.

### 1. Overview

The web resources are grouped into modules according to their purpose.
| M01: Authentication | Web resources associated with user authentication, allowing for logging in and out, registering and recovering credentials. |
|----------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| M02: Users and Personal Profiles | Web resources associated with user accounts. Includes the following system features: users list and search, edit personal profile, delete personal account. |
| M03: Events and Event Content | Web resources associated with events and its assets, such as polls, comments, attendees and statistics. Includes the following system features: events list and search, view, edit and delete event and assets. |
| M04: Static Pages | Web resources associated with the static pages provided by the application: about, contact, faq, home. |
| M05: Administration Management | Web resources linked to administrator exclusive views and platform management: manage reports, disable and delete events, censor event forum messages and manage user accounts. |
| M06: Notifications | Web resources linked to the notifications provided to the users triggered by event invites, join requests or state changes. |

## 2. Permissions

In order to mediate and secure the access of resources, users are divided into different roles.

| NAU | Non-authenticated users | Users without privileges                   |
| --- | ----------------------- | ------------------------------------------ |
| AU  | Authenticated user      | Authenticated user                         |
| AUO | Organizer               | Authenticated user that organizes an event |
| ADM | Administrator           | System administrator                       |

## 3. OpenAPI Specification

The complete API specification is provided below, in OpenAPI (YAML) format.
Additionally, one can consult the same information in our [GitLab repository](https://git.fe.up.pt/lbaw/lbaw2122/lbaw2134/-/blob/main/docs/openapi.yml).

```openapi: "3.0.2"

info:
 title: Bright Events
 version: "1.0"

servers:
 - url: http://lbaw2134.lbaw.fe.up.pt

tags:
 - name: "M01: Authentication"
 - name: "M02: Users and Personal Profiles"
 - name: "M03: Events and Event Content"
 - name: "M04: Static Pages"
 - name: "M05: Administration Management"
 - name: "M06: Notifications"

# Permissions
# NAU - Non-authenticated User
# ADM - System administrator
# AU - Authenticated User, not ADM
# AUO - User that organizes an event

security:
 - cookieAuth: []

paths:
 ### Static pages ###
 /:
   get:
     operationId: R401
     summary: "R401: Home page"
     description: "Provide home page. Access: NAU, AU, AUO, ADM"
     tags:
       - "M04: Static Pages"
     responses:
       "200":
         description: "OK. Show home page (UI01)"

 /privacy-policy:
   get:
     operationId: R402
     summary: "R402: Privacy Policy page"
     description: "Provide privacy policy page. Access: NAU, AU, AUO, ADM"
     tags:
       - "M04: Static Pages"
     responses:
       "200":
         description: "OK. Show privacy policy page (UI02)"

 /terms-and-conditions:
   get:
     operationId: R403
     summary: "R403: Terms and Conditions page"
     description: "Provide terms and conditions page. Access: NAU, AU, AUO, ADM"
     tags:
       - "M04: Static Pages"
     responses:
       "200":
         description: "OK. Show terms and conditions page (UI03)"

 /faq:
   get:
     operationId: R404
     summary: "R404: FAQ page"
     description: "Provide frequently asked questions page. Access: NAU, AU, AUO, ADM"
     tags:
       - "M04: Static Pages"
     responses:
       "200":
         description: "OK. Show FAQ page (UI04)"

 /about:
   get:
     operationId: R405
     summary: "R405: About page"
     description: "Provide about page. Access: NAU, AU, AUO, ADM"
     tags:
       - "M04: Static Pages"
     responses:
       "200":
         description: "OK. Show About page (UI05)"

 /contacts:
   get:
     operationId: R406
     summary: "R406: Contact Us page"
     description: "Provide Contact Us page. Access: NAU, AU, AUO, ADM"
     tags:
       - "M04: Static Pages"
     responses:
       "200":
         description: "OK. Show Contact Us page (UI06)"

 ### Users ###
 /users:
   get:
     operationId: R201
     summary: "R201: Browse Users page"
     tags:
       - "M02: Users and Personal Profiles"
     responses:
       "200":
         description: "OK. Show Browse/Search Users UI (UI10)"
     parameters:
       - in: query
         name: global
         schema:
           type: string
         description: "Full text search keyword"
       - in: query
         name: sort_by
         schema:
           type: string
           enum: ["name", "username"]
           default: "username"
         description: "Defines the value by which the users should be ordered"
       - in: query
         name: order
         schema:
           type: string
           enum: ["ascending", "descending"]
           default: "ascending"
         description: "Defines if it's ascending order or descending order"
       - in: query
         name: page
         schema:
           type: integer
           default: 0
         description: "Starting page of user list"

 /users/{username}:
   get:
     operationId: R202
     summary: "R202: User Profile page"
     description: "Show user profile page. Access: NAU"
     parameters:
       - name: username
         in: path
         required: true
         schema:
           type: string
     tags:
       - "M02: Users and Personal Profiles"
     responses:
       "200":
         description: "Ok. Show User Profile UI (UI11)"
       "404":
         description: "User not found"

   post:
     operationId: R203
     summary: "R203: Block/Unblock an user"
     description: "Blocks/Unblock the current user. Access: ADM"
     tags:
       - "M02: Users and Personal Profiles"
     parameters:
       - name: username
         in: path
         required: true
         schema:
           type: string
     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: string
             format: boolean
     responses:
       "200":
         description: "Ok. Block user."
       "404":
         description: "User not found"

   delete:
     operationId: R204
     summary: "R204: Remove user"
     description: "Remove the current user. Access: ADM and current user"
     tags:
       - "M02: Users and Personal Profiles"
     parameters:
       - name: username
         in: path
         required: true
         schema:
           type: string
     responses:
       "200":
         description: "Ok. Block user."
       "404":
         description: "User not found"

 /users/{username}/edit:
   get:
     operationId: R205
     summary: "R205: Edit User Profile page"
     description: "Provide edit user profile form. Access: AU"
     parameters:
       - name: username
         in: path
         required: true
         schema:
           type: string
     tags:
       - "M02: Users and Personal Profiles"
     responses:
       "200":
         description: "Ok. Show Edit Personal Information UI (UI22)"
       "404":
         description: "User not found"
       "401":
         description: "Unauthorized. User must be logged in"
   post:
     operationId: R206
     summary: "R206: Edit User Profile action"
     description: "Process the new user profile information. Access: AU"
     tags:
       - "M02: Users and Personal Profiles"
     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               password:
                 type: string
                 format: password
               confirm_password:
                 type: string
                 format: password
               name:
                 type: string
               email:
                 type: string
                 format: email
               birth_date:
                 type: string
                 format: date
               bio:
                 type: string
               picture:
                 type: string
                 format: binary
               gender:
                 type: string
                 enum: ["male, female, other"]
     responses:
       "200":
         description: "Ok. Show Edit User Profile UI (UI22)"
       "404":
         description: "User not found"
       "401":
         description: "Unauthorized. User must be logged in"
       "500":
         description: "Internal server error. Invalid data"

 ### Authentication ###
 /login:
   get:
     operationId: R101
     summary: "R101: Login page"
     description: "Provide login form. Access: NAU"
     tags:
       - "M01: Authentication"
     responses:
       "200":
         description: "OK. Show login form (UI09)"
   post:
     operationId: R102
     summary: "R102: Login action"
     description: "Process the login form. Access: NAU"
     tags:
       - "M01: Authentication"
     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               email:
                 type: string
                 format: email
               password:
                 type: string
                 format: password
             required:
               - email
               - password
     responses:
       "302":
         description: "Post credentials processing redirect"
         headers:
           Location:
             description: "Redirect path"
             schema:
               type: string
             examples:
               302Success:
                 description: "Authentication succeeded. Redirecting to user profile (UI19)"
                 value: "/users/{id}"
               302Failure:
                 description: "Authentication failed. Redirect to login form (UI09)"
                 value: "/login"
           Set-Cookie:
             description: "Login session cookie"
             schema:
               type: string
             examples:
               302Success:
                 description: "Current user login session JSESSIONID"
                 value: JSESSIONID=cookie; Path=/; HttpOnly
               302Failure:
                 description: "Invalid login session"
                 value: ""

 /logout:
   post:
     operationId: R103
     summary: "R103: Logout action"
     description: "Logout the currently authenticated user. Access: AU, ADM"
     tags:
       - "M01: Authentication"
     security:
       - cookieAuth: []
     responses:
       "302":
         description: "Success: Post logout redirect"
         headers:
           Location:
             description: "Redirect path"
             schema:
               type: string
             examples:
               302Success:
                 description: "Logout succeeded. Redirecting to home page (UI01)"
                 value: "/"
       "401":
         description: "Unauthorized. User is not logged in"
         headers:
           Location:
             description: "Redirect path"
             schema:
               type: string
             examples:
               302Success:
                 description: "Logout failed. Redirecting to home page (UI01)"
                 value: "/"

 /register:
   get:
     operationId: R104
     summary: "R104: Register page"
     description: "Provide Register form. Access: NAU"
     tags:
       - "M01: Authentication"
     responses:
       "200":
         description: "OK. Show register form (UI08)"
   post:
     operationId: R105
     summary: "R105: Register action"
     description: "Process the Register form. Access: NAU"
     tags:
       - "M01: Authentication"
     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             required: [username, password, name, email, gender]
             properties:
               username:
                 type: string
               password:
                 type: string
                 format: password
               name:
                 type: string
               email:
                 type: string
                 format: email
               birth_date:
                 type: string
                 format: date
               bio:
                 type: string
               picture:
                 type: string
                 format: binary
               gender:
                 type: string
                 enum: ["male, female, other"]
     responses:
       "302":
         description: "Post credentials processing redirect"
         headers:
           Location:
             description: "Redirect path"
             schema:
               type: string
             examples:
               302Success:
                 description: "Authentication succeeded. Redirect to user profile (UI19)"
                 value: "/users/{id}"
               302Failure:
                 description: "Authentication failed. Redirect to register form (UI08)"
                 value: "/register"
           Set-Cookie:
             description: "Login session cookie"
             schema:
               type: string
             examples:
               302Success:
                 description: "Current user login session JSESSIONID"
                 value: JSESSIONID=cookie; Path=/; HttpOnly
               302Failure:
                 description: "Invalid login session"
                 value: ""

 /recover:
   get:
     operationId: R106
     summary: "R106: Recover Password page"
     description: "Provide Recover Password form. Access: NAU"
     tags:
       - "M01: Authentication"
     responses:
       "200":
         description: "OK. Show recover password form (UI23)"
   post:
     operationId: R107
     summary: "R107: Recover Password action"
     description: "Process the Recover Password form. Access: NAU"
     tags:
       - "M01: Authentication"
     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               username:
                 type: string
               email:
                 type: string
                 format: email
             required:
               - username
               - email
     responses:
       "302":
         description: "Success: Post recover credentials processing redirect"
         headers:
           Location:
             description: "Redirect path"
             schema:
               type: string
             examples:
               302Success:
                 description: "Recover succeeded. Redirect to home page (UI01)"
                 value: "/"
               302Failure:
                 description: "Recover failed. Redirect to login form (UI09)"
                 value: "/login"

 ### Administration ###
 /api/reports/event:
   post:
     operationId: R501
     summary: "R501: Report Event action"
     description: "Report an event. Access: AU with event visibility"
     tags:
       - "M05: Administration Management"
     requestBody:
       description: "Report form"
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               id:
                 type: integer
               motive:
                 type: string
                 enum:
                   [
                     "sexual_harassment",
                     "violence_bodily_harm",
                     "nudity_explicit_content",
                     "hate_speech",
                     "other",
                   ]
               description:
                 type: string
               timestamp:
                 type: string
                 format: date-time
             required: [id, motive, description, timestamp]
     responses:
       "401":
         description: "No authentication found. Please login."
       "403":
         description: "You don't have permission to make this request."
       "404":
         description: "Id not found"
       "201":
         description: "OK. Event report created."

 /api/reports/user:
   post:
     operationId: R502
     summary: "R502: Report User action"
     description: "Report an user. Access: AU with user visibility"
     tags:
       - "M05: Administration Management"
     requestBody:
       description: "Report form"
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               id:
                 type: integer
               motive:
                 type: string
                 enum:
                   [
                     "sexual_harassment",
                     "violence_bodily_harm",
                     "nudity_explicit_content",
                     "hate_speech",
                     "other",
                   ]
               description:
                 type: string
               timestamp:
                 type: string
                 format: date-time
             required: [id, motive, description, timestamp]
     responses:
       "401":
         description: "No authentication found. Please login."
       "403":
         description: "You don't have permission to make this request."
       "404":
         description: "Id not found"
       "201":
         description: "User report created."

 /api/reports/comment:
   post:
     operationId: R503
     summary: "R503: Report Comment action"
     description: "Report a comment. Access: AU with comment visibility"
     tags:
       - "M05: Administration Management"
     requestBody:
       description: "Report form"
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               id:
                 type: integer
               motive:
                 type: string
                 enum:
                   [
                     "sexual_harassment",
                     "violence_bodily_harm",
                     "nudity_explicit_content",
                     "hate_speech",
                     "other",
                   ]
               description:
                 type: string
               timestamp:
                 type: string
                 format: date-time
             required: [id, motive, description, timestamp]
     responses:
       "401":
         description: "No authentication found. Please login."
       "403":
         description: "You don't have permission to make this request."
       "404":
         description: "Id not found"
       "201":
         description: "Message report created."

 /api/reports/{id}:
   post:
     operationId: R504
     summary: "R504: Handle Report"
     description: "Change report state, manipulating the resource availability. Access: ADM"
     tags:
       - "M05: Administration Management"
     parameters:
       - name: id
         in: path
         required: true
         schema:
           type: integer
     requestBody:
       description: "Action to take"
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               action:
                 type: string
                 enum: ["ignore_report", "block_resource", "delete_resource"]
             required: [action]
     responses:
       "200":
         description: "OK. Action taken."
       "401":
         description: "No authentication found. Please login."
       "403":
         description: "You don't have permission to make this request."
       "404":
         description: "Id not found."
       "500":
         description: "Internal server failure."

 /reports:
   get:
     operationId: R505
     summary: "R505: Browse Reports page"
     description: "Show reports list page.  Access: ADM."
     parameters:
       - in: query
         name: page
         required: false
         schema:
           type: integer
           default: 0
         description: "Starting page of reports list"
     tags:
       - "M05: Administration Management"
     responses:
       "401":
         description: "No authentication found. Please login."
       "403":
         description: "You don't have permission to access this page."
       "200":
         description: "OK. Show reports list page (UI07)"

 ### Events ###
 /events:
   get:
     operationId: R301
     summary: "R301: Browse Events page"
     tags:
       - "M03: Events and Event Content"
     description: "Show Browse Events page. Access: NAU"
     parameters:
       - in: query
         name: page
         required: false
         schema:
           type: integer
           default: 0
         description: "Starting page of reports list"
     responses:
       "200":
         description: "Ok. Show Browse Events page (UI12)"

 /events/create:
   get:
     operationId: R302
     summary: "R302: Create Event page"
     description: "Show Create Event form. Access: AU"
     tags:
       - "M03: Events and Event Content"
     responses:
       "200":
         description: "Ok. Show Create Event form (UI17)"
   post:
     operationId: R303
     summary: "R303: Create Event action"
     description: "Submit create event form. Access: AU"
     tags:
       - "M03: Events and Event Content"
     requestBody:
       required: true
       content:
         multipart/form-data:
           schema:
             type: object
             properties:
               title:
                 type: string
               description:
                 type: string
               isPrivate:
                 type: boolean
               date:
                 type: string
               cover_image:
                 type: string
                 format: binary
               tags:
                 type: array
                 items:
                   type: integer
     responses:
       "401":
         description: "Event creation requires authentication"
       "200":
         description: "Ok. Event created."

 /events/{id}:
   get:
     operationId: R304
     summary: "R304: Event Details page"
     description: "Show Event page. Access: NAU"
     tags:
       - "M03: Events and Event Content"
     parameters:
       - name: id
         in: path
         required: true
         schema:
           type: integer
     responses:
       "404":
         description: "Event not found"
       "403":
         description: "User doesn't have permission to view event"
       "401":
         description: "Event requires authentication to be viewed"
       "200":
         description: "OK. Show event details page (UI18)"
   delete:
     operationId: "R305"
     summary: "R305: Remove Event action"
     description: "Remove event. Access: AUO"
     tags:
       - "M03: Events and Event Content"
     parameters:
       - name: id
         required: true
         in: path
         schema:
           type: integer
         description: "Event id"
     responses:
       "200":
         description: "Ok. Event deleted."
       "404":
         description: "Event not found"
       "403":
         description: "User doesn't have permission to remove event"

 /events/{id}/edit:
   get:
     operationId: "R306"
     summary: "R306: Edit Event page"
     description: "Show Edit Event page. Access: AUO"
     parameters:
       - name: id
         in: path
         required: true
         schema:
           type: integer
     tags:
       - "M03: Events and Event Content"
     responses:
       "404":
         description: "Event not found"
       "200":
         description: "Ok. Show event edition page (UI18)"
   post:
     operationId: "R307"
     summary: "R307: Edit Event action"
     description: "Update event details. Access: AUO"
     parameters:
       - name: id
         in: path
         required: true
         schema:
           type: integer
     tags:
       - "M03: Events and Event Content"
     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               title:
                 type: string
               description:
                 type: string
               private:
                 type: boolean
                 default: false
               date:
                 type: string
               tags:
                 type: array
                 items:
                   type: integer
               cover_image:
                 type: string
                 format: binary
             required: [title, description, date]
     responses:
       "200":
         description: "Ok. Event updated."
       "401":
         description: "Unauthorized. User must be the event organizer"
       "500":
         description: "Internal server error. Invalid data"

 /api/events/{id}/attendees:
   get:
     operationId: "R308"
     summary: "R308: Event Attendees list"
     tags:
       - "M03: Events and Event Content"
     parameters:
       - in: query
         name: id
         schema:
           type: integer
         description: "Event id"
       - in: query
         name: offset
         schema:
           type: integer
         description: "Offset of attendees"
       - in: query
         name: size
         schema:
           type: integer
         description: "Determines the number of attendees given"
     responses:
       "404":
         description: "Event not found"
       "200":
         description: "OK. Show event attendees"
         content:
           application/json:
             schema:
               type: array
               items:
                 type: object
                 properties:
                   id:
                     type: integer
                   name:
                     type: string
                   user_picture:
                     type: integer

   post:
     operationId: "R309"
     summary: "R309: Register Attendance action"
     description: "Add event attendance. Access: AUO, AU (not AUO), Invited user(private events)"
     tags:
       - "M03: Events and Event Content"
     parameters:
       - in: query
         name: eventId
         schema:
           type: integer
         description: "Event id"
       - in: query
         name: attendeeId
         schema:
           type: integer
         description: "Attendee id"
     responses:
       "200":
         description: "Ok. Attendance added."
       "401":
         description: "Unauthorized."
       "500":
         description: "Internal server error. Invalid data"

   delete:
     operationId: "R310"
     summary: "R310: Remove Attendance action"
     description: "Remove event attendance. Access: AUO, attendant"
     tags:
       - "M03: Events and Event Content"
     parameters:
       - in: query
         name: eventId
         schema:
           type: integer
         description: "Event id"
       - in: query
         name: attendaceId
         schema:
           type: integer
         description: "Attendance id"
     responses:
       "200":
         description: "Ok. Attendance deleted."
       "404":
         description: "Attendance not found"
       "403":
         description: "User doesn't have permission to remove attendance"

 /api/events/{id}/comments:
   get:
     operationId: "R311"
     summary: "R311: Event Comments list"
     description: "Retrieve event comments. Access: NAU"
     parameters:
       - in: query
         name: offset
         schema:
           type: integer
           default: 0
         description: "Starting index of user list"
       - in: query
         name: size
         schema:
           type: integer
         description: "Size of sublist to show"
     tags:
       - "M03: Events and Event Content"
     responses:
       "200":
         description: "Ok. Show event comments"
   post:
     operationId: "R312"
     summary: "R312: Comment Event action"
     description: "Create comment. Access: AU"
     parameters:
       - name: id
         in: path
         required: true
         schema:
           type: integer
     tags:
       - "M03: Events and Event Content"
     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               body:
                 type: string
               user:
                 type: integer
               event:
                 type: integer
               author:
                 type: integer
             required: [body, user, event, author]
     responses:
       "200":
         description: "Ok. Comment created"
       "401":
         description: "Unauthorized. User must be an attendee or organizer"
       "500":
         description: "Internal server error. Invalid data"

 /api/events/{eventId}/comments/{commentId}:
   get:
     operationId: "R313"
     summary: "R313: Event Comment details"
     tags:
       - "M03: Events and Event Content"
     parameters:
       - name: eventId
         in: path
         required: true
         schema:
           type: integer
       - name: commentId
         in: path
         required: true
         schema:
           type: integer
       - in: query
         name: offset
         schema:
           type: integer
         description: "Offset of comments"
       - in: query
         name: size
         schema:
           type: integer
         description: "Determines the number of comments given"
     responses:
       "404":
         description: "Event not found"
       "200":
         description: "OK, show event comments "
         content:
           application/json:
             schema:
               type: array
               items:
                 type: object
                 properties:
                   id:
                     type: integer
                   author:
                     type: integer
                   author_picture:
                     type: integer
                   body:
                     type: string
   delete:
     operationId: "R314"
     summary: "R314: Delete Comment action"
     description: "Delete Comment from database. Access: AUO, author"
     parameters:
       - name: eventId
         in: path
         required: true
         schema:
           type: integer
       - name: commentId
         in: path
         required: true
         schema:
           type: integer
     tags:
       - "M03: Events and Event Content"
     responses:
       "200":
         description: "OK. Deletion successful"
       "401":
         description: "Unauthorized. Not enough permissions"
       "404":
         description: "Comment not found"

 /api/events/{id}/invites:
   get:
     operationId: "R315"
     summary: "R315: Event Invites list"
     description: "Show event invites. Access: AUO"
     tags:
       - "M03: Events and Event Content"
     parameters:
       - in: query
         name: id
         schema:
           type: integer
         description: "Event id"
       - in: query
         name: offset
         schema:
           type: integer
         description: "Offset of invites"
       - in: query
         name: size
         schema:
           type: integer
         description: "Determines the number of invites given"
     responses:
       "403":
         description: "User doesn't have permission to view event invites"
       "402":
         description: "Requires authentication to view event invites"
       "404":
         description: "Event not found"
       "200":
         description: "OK, show event invites "
         content:
           application/json:
             schema:
               type: array
               items:
                 type: object
                 properties:
                   invite_id:
                     type: integer
                   attendee_id:
                     type: integer
                   event_id:
                     type: integer
   post:
     operationId: "R316"
     summary: "R316: Invite User action"
     description: "Invite user to event. Access: AUO"
     tags:
       - "M03: Events and Event Content"
     requestBody:
       description: "Invite information"
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               username:
                 type: string
             required: [username]
     responses:
       "200":
         description: "Ok. Invite created."
       "401":
         description: "Unauthorized. User must be an organizer"
       "500":
         description: "Internal server error. Invalid data"

 /api/events/{eventId}/invites/{requestId}:
   delete:
     operationId: "R317"
     summary: "R317: Delete Invite action"
     description: "Delete Invite from database. Access: AUO"
     parameters:
       - name: eventId
         in: path
         required: true
         schema:
           type: integer
       - name: requestId
         in: path
         required: true
         schema:
           type: integer
     tags:
       - "M03: Events and Event Content"
     responses:
       "200":
         description: "OK. Deletion successful"
       "401":
         description: "Unauthorized. Not enough permissions"
       "404":
         description: "Invite not found"

 /api/events/{id}/join-requests:
   get:
     operationId: "R318"
     summary: "R318: Event Join Requests list"
     tags:
       - "M03: Events and Event Content"
     parameters:
       - name: id
         in: path
         required: true
         schema:
           type: integer
       - name: requestId
         in: path
         required: true
         schema:
           type: integer
       - in: query
         name: offset
         schema:
           type: integer
         description: "Offset of join requests"
       - in: query
         name: size
         schema:
           type: integer
         description: "Determines the number of join requests given"
     responses:
       "403":
         description: "User doesn't have permission to view event join requests"
       "402":
         description: "Requires authentication to view event join requests"
       "404":
         description: "Event not found"
       "200":
         description: "OK, show event join requests"
         content:
           application/json:
             schema:
               type: array
               items:
                 type: object
                 properties:
                   id:
                     type: integer
                   attendee_id:
                     type: integer
                   event_id:
                     type: integer
   post:
     operationId: "R319"
     summary: "R319: Request Event Join action"
     description: "Request to join an event. Access: AU"
     parameters:
       - name: id
         in: path
         required: true
         schema:
           type: integer
     tags:
       - "M03: Events and Event Content"
     requestBody:
       description: "Join request information"
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               attendee_id:
                 type: integer
             required: [attendee_id]
     responses:
       "200":
         description: "OK. Request created"
       "401":
         description: "Unauthorized. Not enough permissions"

 /api/events/{eventId}/join-requests/{requestId}:
   delete:
     operationId: "R320"
     summary: "R320: Delete Join Request action"
     description: "Delete Join request from database. Access: AUO"
     parameters:
       - name: eventId
         in: path
         required: true
         schema:
           type: integer
       - name: requestId
         in: path
         required: true
         schema:
           type: integer
     tags:
       - "M03: Events and Event Content"
     responses:
       "200":
         description: "OK. Deletion successful"
       "401":
         description: "Unauthorized. Not enough permissions"
       "404":
         description: "Join request not found"

 /api/events/{id}/polls:
   get:
     operationId: "R321"
     summary: "R321: Event Polls list"
     tags:
       - "M03: Events and Event Content"
     description: "Retrieve event polls list. Access: NAU"
     parameters:
       - in: query
         name: id
         required: true
         schema:
           type: integer
       - in: query
         name: offset
         schema:
           type: integer
           default: 0
         description: "Starting index of user list"
       - in: query
         name: size
         schema:
           type: integer
         description: "Size of sublist to show"
     responses:
       "200":
         description: "Ok. Show polls list"
         content:
           application/json:
             schema:
               type: array
               items:
                 type: object
                 properties:
                   title:
                     type: string
                   description:
                     type: string
                   options:
                     type: object
                     properties:
                       answer:
                         type: string
                       voters:
                         type: array
                         items:
                           type: integer
                           description: Voter id
                   items:
                     type: string
       "404":
         description: "Event not found"
   post:
     operationId: "R322"
     summary: "R322: Create Event Poll action"
     description: "Create event poll. Access: AU"
     tags:
       - "M03: Events and Event Content"
     parameters:
       - in: path
         name: id
         required: true
         schema:
           type: integer
     requestBody:
       description: "Poll information"
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               title:
                 type: string
               description:
                 type: string
               options:
                 type: array
                 items:
                   type: string
             required: [title, description, options]
     responses:
       "200":
         description: "Ok. Poll created"
       "404":
         description: "Event not found"
       "401":
         description: "Not enough permissions"

 /api/events/{eventId}/polls/{pollId}:
   patch:
     operationId: "R323"
     summary: "R323: Edit Event Poll action"
     description: "Edit event poll. Access: poll author"
     tags:
       - "M03: Events and Event Content"
     parameters:
       - in: path
         name: eventId
         required: true
         schema:
           type: integer
       - in: path
         name: pollId
         required: true
         schema:
           type: integer
     requestBody:
       description: "Poll information"
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               title:
                 type: string
               description:
                 type: string
               options:
                 type: array
                 items:
                   type: string
     responses:
       "200":
         description: "Ok. Poll edited"
       "404":
         description: "Poll not found"
       "401":
         description: "Not enough permissions"
   delete:
     operationId: "R324"
     summary: "R324: Delete Event Poll action"
     description: "Remove vote on a poll option. Access: AU"
     tags:
       - "M03: Events and Event Content"
     parameters:
       - in: path
         name: eventId
         required: true
         schema:
           type: integer
       - in: path
         name: pollId
         required: true
         schema:
           type: integer
     responses:
       "404":
         description: "Poll not found"
       "200":
         description: "Poll removed"
       "401":
         description: "Not enough permissions"

 /api/events/{eventId}/polls/{pollId}/{pollOption}:
   post:
     operationId: "R325"
     summary: "R325: Poll Option Vote action"
     description: "Vote on a poll option. Access: AU"
     tags:
       - "M03: Events and Event Content"
     parameters:
       - in: path
         name: eventId
         required: true
         schema:
           type: integer
       - in: path
         name: pollId
         required: true
         schema:
           type: integer
       - in: path
         required: true
         name: pollOption
         schema:
           type: integer
     responses:
       "404":
         description: "Poll option not found"
       "200":
         description: "Poll option vote registered"
       "401":
         description: "User is not logged in"
   delete:
     operationId: "R326"
     summary: "R326: Poll Option Vote action"
     description: "Remove vote on a poll option. Access: AU"
     tags:
       - "M03: Events and Event Content"
     parameters:
       - in: path
         name: eventId
         required: true
         schema:
           type: integer
       - in: path
         name: pollId
         required: true
         schema:
           type: integer
       - in: path
         required: true
         name: pollOption
         schema:
           type: integer
     responses:
       "404":
         description: "Poll option not found"
       "200":
         description: "Poll option vote removed"
       "401":
         description: "User did not vote on this poll option"

 ### Notifications ###
 /api/notifications:
   get:
     operationId: R601
     summary: "R601: Retrieve notifications"
     description: "Retrieve user notifications. Access: AU"
     tags:
       - "M06: Notifications"
     parameters:
       - in: query
         name: offset
         schema:
           type: integer
           default: 0
         description: "Starting index of user list"
       - in: query
         name: size
         schema:
           type: integer
         description: "Size of sublist to show"
     responses:
       "401":
         description: "Unauthorized. User must be logged in"
       "403":
         description: "You don't have permissions to make this request"
       "200":
         description: "OK. Retrieve user notifications"
         content:
           application/json:
             schema:
               type: array
               items:
                 type: object
                 properties:
                   id:
                     type: string
                   date:
                     type: string
                     format: date-time
                   type:
                     type: string
                     enum:
                       [
                         "disabled_event",
                         "cancelled_event",
                         "join_request",
                         "accepted_request",
                         "declined_request",
                         "invite",
                         "accepted_invite",
                         "declined_invite",
                         "new_comment",
                         "new_poll",
                         "poll_closed",
                       ]
                   asset_type:
                     type: string
                     enum: ["event", "attendance_request", "poll", "comment"]
                   asset_id:
                     type: string

 /api/notifications/{id}:
   patch:
     operationId: R602
     summary: "R602: Edit notification"
     description: "Process the new notification information. Access: AU"
     tags:
       - "M06: Notifications"
     parameters:
       - name: id
         in: path
         required: true
         schema:
           type: integer
     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               is_seen:
                 type: boolean
             required: [is_seen]
     responses:
       "401":
         description: "Unauthorized. User must be logged in"
       "404":
         description: "Notification not found"
       "500":
         description: "Internal server error"
       "200":
         description: "Ok. Update notification"
```

# A8: Vertical Prototype

## 1. Implemented Features

### 1.1. Implemented User Stories

The user stories implemented in the prototype are mentioned in the following table.

| User story | Name                                               | Priority | Description                                                                                                                                                                                  |
| ---------- | -------------------------------------------------- | -------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| A01        | Sign-in                                            | high     | As an Administrator, I want to log into the plattform.                                                                                                                                       |
| A02        | Sign-out                                           | high     | As an Administrator, I want to leave the authenticated area of the plattform.                                                                                                                |
| A03        | Browse Events                                      | high     | As an Administrator, I want to be able to browse events with either visibility, so that I can verify that they comply with the platform’s rules.                                             |
| A04        | View Event Details                                 | high     | As an Administrator, I want to view an event’s page, containing its details and forum, so that I can verify that they comply with the platform’s rules.                                      |
| A05        | Manage Reports                                     | high     | As an Administrator, I want to be able to read and attend to reports, so that I can take into consideration the community’s concerns about accounts, events or comments.                     |
| A06        | Delete Event                                       | high     | As an Administrator, I want to be able to delete an event, in case it does not comply with the platform’s rules.                                                                             |
| A07        | Manage User Accounts                               | low      | As an Administrator, I want to be able to view account details and search user accounts, so that I can take action (block or remove) if the owner does not comply with the platform’s rules. |
| V01        | See Home                                           | high     | As a Visitor, I want to access the home page, so that I can see a brief presentation of the website.                                                                                         |
| V02        | See About                                          | high     | As a Visitor, I want to access the about page, so that I can find detailed information about the website, such as the creators and the nature of the provided service.                       |
| V03        | Browse Public Events                               | high     | As a Visitor, I want to browse public events, sorted by date or number of attendees.                                                                                                         |
| V04        | Consult FAQ                                        | high     | As a Visitor, I want to read the FAQ, so that I can get answers to common questions.                                                                                                         |
| V07        | Consult Contacts                                   | high     | As a Visitor, I want to consult the contacts of the platform creators, so I can reach them in case of need.                                                                                  |
| V08        | Search                                             | high     | As a Visitor, I want to search public events by keyword, so that I can quickly find events I’m interested in.                                                                                |
| V09        | View Public Event Details                          | high     | As a Visitor, I want to view an event’s page, containing its details and forum.                                                                                                              |
| V010       | Explore Events By Tag, Date, Location or Organizer | medium   | As a Visitor, I want to be able browse through public events while filtering them through tags, date, location or organizer.                                                                 |
| NAU01      | Sign-in                                            | high     | As a Non-Authenticated User, I want to be able to login into my account, so that I can access privileged information.                                                                        |
| NAU02      | Sign-up                                            | high     | As a Non-Authenticated-User, I want to be able to register myself in the system in order to later be able to sign-into my personal account in the system.                                    |
| AU01       | Create Event                                       | high     | As an Authenticated User, I want to be able to create a public or private event.                                                                                                             |
| AU02       | Manage My Events                                   | high     | As an Authenticated User, I want to be able to view, edit and remove my previously created events.                                                                                           |
| AU06       | Sign-out                                           | high     | As an Authenticated User, I want to be able to sign-out of my account and continue visiting the website as a Visitor.                                                                        |
| AU08       | View and Edit Profile Page                         | medium   | As an Authenticated User, I want to view and edit my profile page information.                                                                                                               |
| AU10       | Search Authenticated Users                         | medium   | As an Authenticated User, I want to be able to search for other Authenticated User profiles.                                                                                                 |
| AU11       | View Authenticated Users Profile                   | medium   | As an Authenticated User, I want to be able to view other Authenticated Users’ profiles.                                                                                                     |
| AUO01      | Edit Event Details                                 | high     | As an Organizer, I want to be able to edit the details of an event of mine, such as title, date, description or location.                                                                    |
| AUO02      | Add User to Event                                  | high     | As an Organizer, I want to be able to add an user that is going to participate and add value to my event.                                                                                    |
| AUO03      | Manage Event Participants                          | high     | As an Organizer, I want to be able to view who is going to participate in my event and remove whomever I do not wish to have at my event.                                                    |
| AUO05      | Cancel Event                                       | high     | As an Organizer, I want to be able to cancel my event.                                                                                                                                       |
| AUO09      | Send Event Invitations                             | medium   | As an Organizer, I want to be able to invite other users to attend my event.                                                                                                                 |
| AUA01      | Access Event Page                                  | high     | As an Attendee, I want to access an event page, so that I can interact with it                                                                                                               |
| AUA02      | Join Event                                         | high     | As an Attendee, I want to join an event, so that other people get to know I am attending.                                                                                                    |
| AUA08      | View Attendees List                                | medium   | As an Attendee, I want to view the attendees list, so that I know who else is attending the event.                                                                                           |

### 1.2. Implemented Web Resources

The web resources implemented in the prototype are mentioned in the following table.

#### M01: Authentication

| Web Resource Reference | URL                                                     |
| ---------------------- | ------------------------------------------------------- |
| R101: Login page       | GET [/login](http://lbaw2134.lbaw.fe.up.pt/login)       |
| R102: Login action     | POST /login                                             |
| R103: Logout action    | POST /logout                                            |
| R104: Register page    | GET [/register](http://lbaw2134.lbaw.fe.up.pt/register) |
| R105: Register action  | POST /register                                          |

#### M02: Users and Personal Profiles

| Web Resource Reference         | URL                                               |
| ------------------------------ | ------------------------------------------------- |
| R201: Browse Users page        | GET [/users](http://lbaw2134.lbaw.fe.up.pt/users) |
| R202: User Profile page        | GET /users/{username}                             |
| R203: Block/Unblock an User    | POST /users/{username}                            |
| R204: Remove User              | DELETE /users/{username}                          |
| R205: Edit User Profile page   | GET /users/{username}/edit                        |
| R206: Edit User Profile action | POST /users/{username}/edit                       |

#### M03: Events and Event content

| Web Resource Reference    | URL                                                                   |
| ------------------------- | --------------------------------------------------------------------- |
| R301: Browse Events page  | GET [/events](http://lbaw2134.lbaw.fe.up.pt/events                    |
| R302: Create Event page   | GET [/events/create](<(http://lbaw2134.lbaw.fe.up.pt/events/create)>) |
| R303: Create Event action | POST /events/create                                                   |
| R304: Event Details page  | GET /events/{id}                                                      |
| R305: Remove Event action | DELETE /events{id}                                                    |
| R306: Edit Event page     | GET /events/{id}/edit                                                 |
| R306: Edit Event action   | POST /events/{id}/edit                                                |

#### M04: Static Pages

| Web Resource Reference | URL                                                     |
| ---------------------- | ------------------------------------------------------- |
| R401: Home page        | GET [/](http://lbaw2134.lbaw.fe.up.pt/)                 |
| R404: FAQ page         | GET [/faq](http://lbaw2134.lbaw.fe.up.pt/faq)           |
| R405: About page       | GET [/about](http://lbaw2134.lbaw.fe.up.pt/about)       |
| R406: Contact Us page  | GET [/contacts](http://lbaw2134.lbaw.fe.up.pt/contacts) |

#### M05: Administration Management

| Web Resource Reference    | URL                                                   |
| ------------------------- | ----------------------------------------------------- |
| R505: Browse Reports page | GET [/reports](http://lbaw2134.lbaw.fe.up.pt/reports) |

#### M06: Notifications

| Web Resource Reference | URL |
| ---------------------- | --- |
| Not implemented        |     |

## 2. Prototype

The prototype is available at [http://lbaw2134.lbaw.fe.up.pt/](http://lbaw2134.lbaw.fe.up.pt/)

```
Credentials:
admin user: admin@admin.com/admin
regular user: WilliamSKing@teleworm.us/willking
```

The code is available at
[https://git.fe.up.pt/lbaw/lbaw2122/lbaw2134](https://git.fe.up.pt/lbaw/lbaw2122/lbaw2134)

## Editor

Bruno Gomes, up201906401@edu.fe.up.pt

## Group details

GROUP2134, 29/11/2021

Bruno Gomes, up201906401@edu.fe.up.pt\
Bruno Mendes, up201906166@edu.fe.up.pt\
David Preda, up201904726@edu.fe.up.pt\
José Costa, up201907216@edu.fe.up.pt