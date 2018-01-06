<p align="center">
    <br>
        <h1 align="center">JOE SHOPPING</h1>
    <br>
</p>

USER FEATURES
-------------------
**Add Product to cart (even user still is not login)**

**If Product empty cant be add to cart**

**Can use coupon with conditional :**
1. Coupon stock is available         _**(check coupon section below)**_
2. Coupon date is in range of today. **_(check coupon section below)_**

**Discount on coupon have two categories:**
1. Discount based on Percentage
2. Discount based on Value

**See Cart (even user still is not login)**

**Pay product on the cart, and those condition will follow:**
1. Quantity every product will be reduced based on **how many product user buying**.
2. If use coupon and eligible to use that, then coupon will be reduced **one**.

**See Transaction List Based on User Login**

**Upload proof of payment (Using AWS)**
 
 
 
-------------------
ADMIN FEATURES
-------------------
See All Transaction Users who has upload payment proof

Update transaction with status, shippingId, courierId





WEB SERVER - OS - HOSTING - DOMAIN 
-------------------
**>_Nginx_**

**>_Ubuntu -> Lightsail -> AWS_**

**>_AWS S3_**

_**>AWS Route 53**_


HOW TO USE OR RUN ?
------------

**1. For user:**

`http://joeshop.jkawistara.com/`

email: **user@gmail.com or user2@gmail.com**

password : **password**

**2. For admin:**

`http://joeshop.jkawistara.com/admin/`

email: **admin@gmail.com**

password : **password**


LIST OF COUPON
------------
You can use this coupon when insert coupon. (Please use '**Coupon Code**' column when inserting)

![alt text](https://s3-ap-southeast-1.amazonaws.com/jojoshoping/coupons.jpg)



LIST OF BANK
-------------
Default bank is Bank Shopping Joe. (Please use '**id**' column when inserting)

![alt text](https://s3-ap-southeast-1.amazonaws.com/jojoshoping/banks.jpg)



LIST OF COURIER
-------------
You can insert the id from this courier when admin update transaction (shipping) (Please use '**id**' when inserting)

![alt text](https://s3-ap-southeast-1.amazonaws.com/jojoshoping/couriers.jpg)


ASSUMPTIONS 
------------

1. Cart only use sessions

2. Use different sessions for user or admin

3. Payment of proof right now only work with .jpg and .png
 
4. Admin only can be created via admin
 
5. Email is unique either admin or user can't be same. 


DATABASE SCHEME 
------------
![alt text](https://s3-ap-southeast-1.amazonaws.com/jojoshoping/db_scheme.png)




------------



