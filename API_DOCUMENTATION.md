# API Documentation - Mobile App Integration

## Base URL
```
https://your-domain.com/api
```

## Authentication
All endpoints (except login and register) require authentication using Laravel Sanctum tokens.

Include the token in the Authorization header:
```
Authorization: Bearer {your-token}
```

---

## Endpoints

### 1. User Registration
**Endpoint:** `POST /register`

**Description:** Register a new user account.

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Request Body:**
```json
{
  "name": "John",
  "surname": "Doe",
  "email": "john.doe@example.com",
  "phone_number": "0555123456",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response (201 Created):**
```json
{
  "message": "User registered successfully",
  "user": {
    "id": 1,
    "name": "John",
    "surname": "Doe",
    "email": "john.doe@example.com",
    "phone_number": "0555123456"
  },
  "token": "1|abcdef123456..."
}
```

---

### 2. User Login
**Endpoint:** `POST /login`

**Description:** Login with existing credentials.

**Headers:**
```
Content-Type: application/json
Accept: application/json
```

**Request Body:**
```json
{
  "email": "john.doe@example.com",
  "password": "password123"
}
```

**Response (200 OK):**
```json
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "John",
    "surname": "Doe",
    "email": "john.doe@example.com",
    "phone_number": "0555123456"
  },
  "token": "2|ghijkl789012..."
}
```

**Error Response (401 Unauthorized):**
```json
{
  "message": "Invalid credentials"
}
```

---

### 3. User Logout
**Endpoint:** `POST /logout`

**Description:** Logout and revoke current access token.

**Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {your-token}
```

**Response (200 OK):**
```json
{
  "message": "Logged out successfully"
}
```

---

### 4. Get User Profile
**Endpoint:** `GET /profile`

**Description:** Get current authenticated user's profile.

**Headers:**
```
Accept: application/json
Authorization: Bearer {your-token}
```

**Response (200 OK):**
```json
{
  "id": 1,
  "name": "John",
  "surname": "Doe",
  "email": "john.doe@example.com",
  "phone_number": "0555123456",
  "email_verified_at": null,
  "created_at": "2025-09-27T10:30:00.000000Z",
  "updated_at": "2025-09-27T10:30:00.000000Z"
}
```

---

### 5. Get All Products
**Endpoint:** `GET /products`

**Description:** Get list of all available products.

**Headers:**
```
Accept: application/json
Authorization: Bearer {your-token}
```

**Response (200 OK):**
```json
[
  {
    "id": 1,
    "name": "Product Name",
    "description": "Product description here",
    "price": "150.00",
    "stock": 500,
    "image": "http://your-domain.com/storage/products/image.jpg",
    "created_at": "2025-09-27T10:00:00.000000Z"
  },
  {
    "id": 2,
    "name": "Another Product",
    "description": "Another description",
    "price": "200.50",
    "stock": 300,
    "image": "http://your-domain.com/storage/products/image2.jpg",
    "created_at": "2025-09-27T11:00:00.000000Z"
  }
]
```

---

### 6. Create Order
**Endpoint:** `POST /products/{product}/order`

**Description:** Place an order for a specific product.

**Headers:**
```
Content-Type: application/json
Accept: application/json
Authorization: Bearer {your-token}
```

**URL Parameters:**
- `product` (integer, required): Product ID

**Request Body:**
```json
{
  "quantity": 50,
  "address": "123 Main Street, Algiers, Algeria",
  "phone_number": "0555123456"
}
```

**Validation Rules:**
- `quantity`: Required, integer, minimum 10
- `address`: Required, string, max 255 characters
- `phone_number`: Required, string, max 20 characters

**Response (201 Created):**
```json
{
  "message": "Order placed successfully",
  "order": {
    "id": 10,
    "product_name": "Product Name",
    "quantity": 50,
    "total_price": "7500.00",
    "address": "123 Main Street, Algiers, Algeria",
    "phone_number": "0555123456",
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

---

### 7. Get User Orders
**Endpoint:** `GET /orders`

**Description:** Get all orders for the authenticated user.

**Headers:**
```
Accept: application/json
Authorization: Bearer {your-token}
```

**Response (200 OK):**
```json
[
  {
    "id": 10,
    "product_name": "Product Name",
    "quantity": 50,
    "total_price": "7500.00",
    "address": "123 Main Street, Algiers, Algeria",
    "phone_number": "0555123456",
    "status": "pending",
    "created_at": "2025-09-27T12:30:00.000000Z"
  },
  {
    "id": 9,
    "product_name": "Another Product",
    "quantity": 100,
    "total_price": "20050.00",
    "address": "456 Second Avenue, Oran, Algeria",
    "phone_number": "0666789012",
    "status": "paid",
    "created_at": "2025-09-26T15:20:00.000000Z"
  }
]
```

---

### 8. Get Total Spending
**Endpoint:** `GET /orders/total`

**Description:** Get total amount spent by the authenticated user.

**Headers:**
```
Accept: application/json
Authorization: Bearer {your-token}
```

**Response (200 OK):**
```json
{
  "total_spent": "27550.00"
}
```

---

## Order Status Values

Orders can have the following status values:
- `pending`: Order has been placed but not yet paid
- `paid`: Order has been paid
- `shipped`: Order has been shipped to customer

---

## Error Responses

### 401 Unauthorized
```json
{
  "message": "Unauthenticated."
}
```

### 404 Not Found
```json
{
  "message": "Resource not found"
}
```

### 422 Unprocessable Entity (Validation Error)
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "quantity": [
      "The quantity must be at least 10."
    ],
    "address": [
      "The address field is required."
    ]
  }
}
```

### 500 Internal Server Error
```json
{
  "message": "Server error occurred"
}
```

---

## Implementation Notes

### Mobile App Integration Steps:

1. **Registration/Login Flow:**
   - Call `/register` or `/login` endpoint
   - Store the returned token securely (using encrypted storage)
   - Include token in all subsequent API requests

2. **Displaying Products:**
   - Call `/products` to get all available products
   - Display products with name, description, price, stock, and image

3. **Creating Orders:**
   - User selects product and quantity
   - User enters delivery address and phone number
   - Call `/products/{productId}/order` with order details
   - Show success/error message based on response

4. **Viewing Order History:**
   - Call `/orders` to display user's order history
   - Show order ID, product name, quantity, total price, address, phone, status, and date

5. **User Profile:**
   - Call `/profile` to display user information

### Security Considerations:

- Always use HTTPS in production
- Store tokens securely (never in plain text)
- Implement token refresh mechanism for long-lived sessions
- Validate all user inputs before sending to API
- Handle token expiration gracefully

### Testing:

You can test the API using tools like:
- Postman
- Insomnia
- cURL
- Your mobile app's HTTP client

Example cURL request:
```bash
curl -X POST https://your-domain.com/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "john.doe@example.com",
    "password": "password123"
  }'
```

---

## Support

For API support or questions, please contact your development team.
