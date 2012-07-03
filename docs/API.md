# TheiaLive API Documentation (v1.0)

## Introduction
TheiaLive claims to be the easiest **invoicing app** around and to meet this promise,
we've build this app from scratch having evaluated several popular invoicing tools. Yes,
some gave us ideas, others showed us how we should not do it. And we've listened to what
our customers wanted, needed and above all would love to have.

To meet this challenge, we've designed everything around our API to make it robust, stable
and usable beyond our **web based invoicing application**.

## Accounts
There's no application that doesn't have a form of authentication, TheiaLive is no 
different.

### Register an account

**Request:**
* URI: /account/create
* Method: POST
* Body: Empty

**Response:**
* Code: 201 Created
* Body: ```{"location":"/account/1234"}```

**Failure:**
* Code: 500 Server Error
* Body: ```{"error":{"message":"Failure to create account"}}```

### Sign in an account

**Request:**
* URI: /account/1234
* Method: PUT
* Body: ```{"email":"johndoe@example.com","password":"secret1"}```

**Response:**
* Code: 202 Accepted
* Body: empty

**Failure:**
* Code: 401 Unauthorized
* Body: ```{"error":{"message":"Failure to authenticate"}}```

### Sign out of an account

**Request:**
* URI: /account/1234/signoff
* Method: GET
* Body: empty

**Response:**
* Code: 204 No Content
* Body: empty

**Failure:**
* Code: 500 Server Error
* Body: ```{"error":"Failure handling logoff request"}```

### Reset an account

**Request:**
**Response:**
**Failure:**