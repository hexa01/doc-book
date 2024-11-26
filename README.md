
# Doctor Appointment System

The **Doctor Appointment System** is a web-based application built using Laravel that enables patients to book appointments with doctors efficiently.

## Features

- **User Management**  
  - Patient and Doctor registration and login.  
  - Role-based access control.

- **Appointment Booking**  
  - Book, reschedule, or cancel appointments.  
  - Prevent double booking of the same slot or time.

- **Doctor Dashboard**  
  - Manage availability and appointment slots.  
  - View scheduled appointments.

- **Admin Panel**  
  - Manage users (doctors and patients).  
  - Manage specializations.

## Technology Stack

- **Backend:** Laravel (PHP)  
- **Frontend:** Blade templates, Tailwind CSS  
- **Database:** SQLite  

## Clone the Repository

Clone the repository and set up the project:  

```bash
git clone https://www.github.com/hexa01/doc-book
```

---

## Database Schema

### 1. **Users Table**  
- Stores basic user information for both doctors and patients.  
- Includes fields like `name`, `email`, `password`, and `role` (doctor or patient).

### 2. **Doctors Table**  
- Contains doctor-specific details, including the associated specialization.  
- References the `users` table.

### 3. **Patients Table**  
- Contains patient-specific details.  
- References the `users` table.

### 4. **Specializations Table**  
- Lists medical specializations (e.g., Cardiology, Dermatology).

### 5. **Appointments Table**  
- Stores information about patient appointments with doctors.  
- Includes details like `doctor_id`, `patient_id`, `appointment_date`, and `appointment_time`.

---

