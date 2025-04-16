# 6amTech - Task

**A custom WordPress plugin built for the Jr. WordPress Plugin/Theme Developer assessment at 6amTech.**

This plugin demonstrates core skills in plugin development, including admin interfaces, REST API integration, custom database operations, shortcode implementation, AJAX enhancements, and external library integrations.

## 📦 Plugin Features
### 1. Settings Page -- "Welcome Message"
- Adds a **Settings Page** under the WordPress **Settings** menu.
- Admins can input and save a **custom welcome message**.
- The welcome message is displayed at the **top of every post** on the frontend.

### 2. Admin Menu – 6amTech - Task
Adds a top-level menu in the WordPress admin titled "6amTech - Task" with two tabs:

#### 🧾 Contact List
- Displays a **paginated list** of contacts (5 per page).
- Columns: **Name, Email, Mobile, Address**.
- Actions:
  - **Edit** existing contact via modal or inline form.
  - **Delete** contact with confirmation.
- **Shortcode** shown above the table for frontend embedding.

#### ➕ Add New Contact
- A form to **add new contacts** with the following fields:
  - Name
  - Email
  - Mobile
  - Address
- On submission, the contact is saved into a custom database table: `wp_contact_list`

### 3. Shortcode
- Provides a shortcode: `[contact_list]`
- Renders a contact list table on the frontend.

### 4. REST API Endpoint
- A custom REST API endpoint to insert contacts.
- Endpoint: `POST /wp-json/6amtech-task/v1/add-contact`
- Required Parameters (in JSON body):
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "mobile": "123456789",
  "address": "123 Main St"
}
```
- Returns a JSON response with status and message.

### 5. Toastr Integration
- Displays **Toastr.js notifications** for:
  - ✅ Contact Added
  - ✏️ Contact Updated
  - 🗑️ Contact Deleted

- Toastr assets are **only loaded on the custom admin menu pages**.

### 6. Code Quality & Optimization
- ✅ Implements an **autoloader** for class loading.
- ✅ **Bootstrap 5** is loaded only on plugin-specific admin pages.
- ✅ Uses **AJAX** for add/edit/delete operations for a smoother experience.
- ✅ Escaping and sanitization applied where necessary.

## 📄 Installation
1. Download or clone the repository to your WordPress plugins directory:


```bash
wp-content/plugins/6amtech-task/
```
2. Activate the plugin from the WordPress admin.
3. Navigate to:
   - **Settings → Welcome Message** – to customize the frontend message.

    - **6amTech - Task → Contact List** – to manage contacts.

    - **6amTech - Task → Add New Contact** – to insert new contacts.


## 🔧 Developer Notes
- Database table wp_contact_list is created on plugin activation.
- Bootstrap and Toastr assets are enqueued **only** where needed to avoid global bloat.
- AJAX handlers use proper `wp_ajax_` hooks.

## 🧪 Testing REST API
Use Postman or CURL:
```bash
curl -X POST https://yourdomain.com/wp-json/6amtech-task/v1/add-contact \
-H "Content-Type: application/json" \
-d '{
  "name": "Jane Smith",
  "email": "jane@example.com",
  "mobile": "987654321",
  "address": "456 Secondary Ave"
}'
```
## 🧩 Shortcode Example
Place this anywhere on a page/post to show the frontend contact list:
```bash
[contact_list]
```
## 🧼 Cleanup on Uninstall
(Optional: If implemented)
To clean up all plugin data (e.g., database table, options), delete the plugin from the WordPress Plugins page.

## 📚 Credits
- **Bootstrap** – UI components

- **Toastr.js** – Notification system

- **WordPress REST API** – Headless insertions

- **6amTech** – Task and inspiration

## 🧑‍💻 Author
**Md Mesbah Uddin**

Email: msbh214@gmail.com

GitHub: https://github.com/Mesbah214