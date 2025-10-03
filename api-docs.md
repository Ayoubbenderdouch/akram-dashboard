# Akram Dashboard API Documentation

Base URL: `http://localhost:8000/api`

## Authentication

All authenticated endpoints require a Bearer token in the Authorization header:
```
Authorization: Bearer {your_token}
```

---

## Authentication Endpoints

### 1. Register User

**Endpoint:** `POST /register`

**Description:** Register a new user account

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Request Body:**
```json
{
  "name": "Ahmed",
  "surname": "Benali",
  "phone_number": "0551234567",
  "email": "ahmed@example.dz",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Validation Rules:**
- `name`: Required, string, max 255 characters
- `surname`: Required, string, max 255 characters
- `phone_number`: Required, unique, must match Algerian format (05/06/07 + 8 digits)
- `email`: Required, unique, valid email format
- `password`: Required, confirmed, minimum 8 characters

**Success Response (201 Created):**
```json
{
  "message": "User registered successfully",
  "user": {
    "id": 1,
    "name": "Ahmed",
    "surname": "Benali",
    "phone_number": "0551234567",
    "email": "ahmed@example.dz"
  },
  "token": "1|abc123def456..."
}
```

**Error Response (422 Unprocessable Entity):**
```json
{
  "message": "The phone number has already been taken.",
  "errors": {
    "phone_number": [
      "The phone number has already been taken."
    ]
  }
}
```

---

### 2. Login

**Endpoint:** `POST /login`

**Description:** Authenticate user and receive access token

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Request Body:**
```json
{
  "login": "0551234567",
  "password": "password123"
}
```

**Note:** `login` field accepts either phone number or email

**Success Response (200 OK):**
```json
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "Ahmed",
    "surname": "Benali",
    "phone_number": "0551234567",
    "email": "ahmed@example.dz"
  },
  "token": "2|xyz789uvw456..."
}
```

**Error Response (422 Unprocessable Entity):**
```json
{
  "message": "The provided credentials are incorrect.",
  "errors": {
    "login": [
      "The provided credentials are incorrect."
    ]
  }
}
```

---

### 3. Logout

**Endpoint:** `POST /logout`

**Description:** Revoke current access token

**Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Success Response (200 OK):**
```json
{
  "message": "Logged out successfully"
}
```

**Error Response (401 Unauthorized):**
```json
{
  "message": "Unauthenticated."
}
```

---

## Product Endpoints

### 4. Get All Products

**Endpoint:** `GET /products`

**Description:** Retrieve paginated list of all products

**Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Query Parameters:**
- `page` (optional): Page number for pagination

**Success Response (200 OK):**
```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "name": "Organic Olive Oil",
      "bio": "Premium quality organic olive oil from Kabylie region...",
      "image_url": "/storage/products/image.jpg",
      "price": "12.50",
      "min_quantity": 10,
      "stock": 500,
      "created_at": "2025-09-27T05:30:00.000000Z",
      "updated_at": "2025-09-27T05:30:00.000000Z"
    }
  ],
  "first_page_url": "http://localhost:8000/api/products?page=1",
  "from": 1,
  "last_page": 1,
  "last_page_url": "http://localhost:8000/api/products?page=1",
  "next_page_url": null,
  "path": "http://localhost:8000/api/products",
  "per_page": 15,
  "prev_page_url": null,
  "to": 5,
  "total": 5
}
```

---

## Order Endpoints

### 5. Place Order

**Endpoint:** `POST /products/{product_id}/order`

**Description:** Place an order for a specific product

**Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**URL Parameters:**
- `product_id`: ID of the product to order

**Request Body:**
```json
{
  "quantity": 50
}
```

**Validation Rules:**
- `quantity`: Required, integer, minimum 10 (B2B requirement)
- Must not exceed available stock

**Success Response (201 Created):**
```json
{
  "message": "Order placed successfully",
  "order": {
    "id": 1,
    "product_name": "Organic Olive Oil",
    "quantity": 50,
    "total_price": "625.00",
    "status": "pending"
  }
}
```

**Error Response (422 Unprocessable Entity):**
```json
{
  "message": "Insufficient stock available",
  "available_stock": 30
}
```

**Error Response (422 - Validation):**
```json
{
  "message": "The quantity field must be at least 10.",
  "errors": {
    "quantity": [
      "The quantity field must be at least 10."
    ]
  }
}
```

---

### 6. Get User Orders

**Endpoint:** `GET /orders`

**Description:** Retrieve all orders for authenticated user

**Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Success Response (200 OK):**
```json
[
  {
    "id": 1,
    "product_name": "Organic Olive Oil",
    "quantity": 50,
    "total_price": "625.00",
    "status": "shipped",
    "created_at": "2025-09-27T05:30:00.000000Z"
  },
  {
    "id": 2,
    "product_name": "Dates - Deglet Nour",
    "quantity": 100,
    "total_price": "800.00",
    "status": "pending",
    "created_at": "2025-09-27T06:15:00.000000Z"
  }
]
```

---

### 7. Get Total Spent

**Endpoint:** `GET /orders/total`

**Description:** Get total amount spent by authenticated user

**Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Success Response (200 OK):**
```json
{
  "total_spent": "1425.00"
}
```

---

## User Profile Endpoint

### 8. Get User Profile

**Endpoint:** `GET /profile`

**Description:** Retrieve authenticated user's profile information

**Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {token}
```

**Success Response (200 OK):**
```json
{
  "id": 1,
  "name": "Ahmed",
  "surname": "Benali",
  "phone_number": "0551234567",
  "email": "ahmed@example.dz"
}
```

**Error Response (401 Unauthorized):**
```json
{
  "message": "Unauthenticated."
}
```

---

## Status Codes

- `200 OK`: Request successful
- `201 Created`: Resource created successfully
- `401 Unauthorized`: Missing or invalid authentication token
- `404 Not Found`: Resource not found
- `422 Unprocessable Entity`: Validation error

---

## Error Handling

All error responses follow a consistent format:

```json
{
  "message": "Error message description",
  "errors": {
    "field_name": [
      "Specific validation error message"
    ]
  }
}
```

---

## Testing with Postman

### 1. Register a New User
- Method: POST
- URL: `http://localhost:8000/api/register`
- Body (JSON): Include name, surname, phone_number, email, password, password_confirmation

### 2. Login
- Method: POST
- URL: `http://localhost:8000/api/login`
- Body (JSON): Include login (phone or email) and password
- **Copy the token from response**

### 3. Use Token for Authenticated Requests
- Add to Headers:
  - Key: `Authorization`
  - Value: `Bearer {paste_your_token_here}`

### 4. Test Product Endpoints
- GET `http://localhost:8000/api/products`

### 5. Place an Order
- POST `http://localhost:8000/api/products/1/order`
- Body (JSON): `{"quantity": 50}`

### 6. View Your Orders
- GET `http://localhost:8000/api/orders`

### 7. Check Total Spent
- GET `http://localhost:8000/api/orders/total`

---

## Notes

1. **Phone Number Format**: Must start with 05, 06, or 07 followed by 8 digits (Algerian format)
2. **Minimum Order Quantity**: All orders must have a minimum quantity of 10 units (B2B requirement)
3. **Token Management**: Store the token securely and include it in all authenticated requests
4. **Stock Management**: Orders automatically decrement product stock
5. **Order Status**: Orders start with "pending" status and can be updated by admin to "paid" or "shipped"

---

## Common Scenarios

### Scenario 1: Register and Place Order
```
1. POST /api/register → Get token
2. GET /api/products → Browse available products
3. POST /api/products/1/order → Place order
4. GET /api/orders → Verify order placed
```

### Scenario 2: Login and Check Order History
```
1. POST /api/login → Get token
2. GET /api/profile → Verify logged in
3. GET /api/orders → View order history
4. GET /api/orders/total → Check total spending
```

---

*Generated for Akram Dashboard - B2B E-commerce Platform*
*API Version: 1.0*
*Last Updated: September 27, 2025*