# Bright Events
Bright Events is an events management website where people can get together in events and discuss about them.

## The product

At Bright Events, all users can browse public events and user profile pages. If they ever want to organize an event or join one as an attendee, they can create a user account.

An event should have a brief description, a cover image and a location. At its page, a forum is automatically created, to allow for community discussions. The organizer may also create a poll to ask their audience about a specific question. Lastly, statistics about gender and age are available to better describe the event's audience.

Private events have their place, too. They are only accessible by the URL and have all sections but the description hidden to a user that is not attending it. The user can request the organizer to join and, if accepted, will be able to interact with the event as if it was a public one.
Real-time notifications provide dynamism to the website. If, for example, an attendee comments on an event a user is organizing, the user will be notified on real-time, and can check the activity log at any time, at the top bar.

Lastly, admins exist to moderate the content and handle community reports about events, user or comments. They may take severe action, blocking or deleting the asset, or choose to ignore the report, if they do not agree with the reasons provided.

### Installation
Install dependencies and serve the website:

    composer install
    php artisan serve --env local

For the database, start docker containers:

    docker-compose build
    docker-compose up
    
Seed the database with our population script:

    php artisan db:seed --env local

### Usage

#### Administration Credentials

| Username   | Password   |
|------------|------------|
| admin      | admin1234   |

#### User Credentials
| Type       | Username   | Password  |
|------------|------------|-----------|
| User       | peterpeter | peterpeter|
| User       |lam_2002    | lam_2002  |
| User       | maddy_90   | maddy_90  |


## Group details
Bruno Gomes, up201906401@edu.fe.up.pt\
Bruno Mendes, up201906166@edu.fe.up.pt\
David Preda, up201904726@edu.fe.up.pt\
José Costa, up201907216@edu.fe.up.pt
