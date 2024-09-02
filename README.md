# Test Platform App

This project is a comprehensive test platform built using Vue, Laravel, and MySQL. The platform allows hosts to create and manage tests, send invitations, track participant progress, and monitor test sessions in real-time. The app includes features such as authentication, real-time notifications, and an anti-cheat system.

## Features

### Authentication & Authorization
- **Session-based Authentication:** Secure login for hosts and participants using Laravel Sanctum.
- **Access Control:** Only authenticated users can manage or participate in tests.

### Test & Session Management
- **Create Tests:** Hosts can create, edit, delete, and print tests.
- **Session Management:** Hosts can create test sessions and send invitations via email to participants.
- **Real-Time Monitoring:** Hosts can see who is taking the test, monitor their progress, and view results in real-time.

### Real-Time Notifications
- **Pusher Integration:** Real-time notifications for participants when they accept or decline test invitations.
- **Session Reminders:** Notifications sent 30 minutes before the start of the test session.

### Participant Tracking
- **Invitation Management:** Hosts can track how many participants accepted or declined the invitation.
- **Attempt Monitoring:** Hosts can monitor attempts for each session and see how many participants passed or failed.

### Anti-Cheat System
- **Cursor Tracking:** Detect if a participant's cursor is out of the window for more than 2 seconds. After 3 instances, the participant is flagged as having cheated.
- **Automatic Test Termination:** If the time runs out, the test is automatically terminated.

### Results & Scoring
- **Real-Time Scoring:** Monitor participants’ progress in real-time, including the number of questions answered and their scores.
- **Pass/Fail/Cheat Status:** Real-time updates on whether participants passed, failed, or cheated during the test.

## Tech Stack

- **Vue.js:** Frontend framework for building the user interface.
- **Laravel:** Backend framework for managing server-side logic and database operations.
- **MySQL:** Relational database for storing test data and user information.
- **Laravel Sanctum:** For session-based authentication.
- **Pusher:** For real-time notifications and updates.
- **Semantic UI:** For responsive and customizable UI components.
- **PrimeVue:** UI component library for Vue.js with a wide range of rich UI elements.

## Link To See The Project:
- https://drive.google.com/file/d/1CKwYdtfPdiBmKx52o6xusNESWdzLsrvt/view?usp=sharing (Part 1)
-https://drive.google.com/file/d/1BCmtM-5T2vM5RnsZN1yIuETrjN6iJASv/view?usp=sharing (Part 2)
## Installation

### Prerequisites

- PHP >= 7.4
- Composer
- MySQL
- Node.js & npm

### Setup

1. **Clone the repository:**

    ```bash
    git clone https://github.com/HoussemMhiri/Test-Platform.git
    ```

2. **Install PHP dependencies:**

    ```bash
    composer install
    ```

3. **Install Node.js dependencies:**

    ```bash
    npm install
    ```

4. **Set up environment variables:**

    - Copy `.env.example` to `.env`.
    - Configure your database settings and Pusher credentials in the `.env` file.

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password

    PUSHER_APP_ID=your_pusher_app_id
    PUSHER_APP_KEY=your_pusher_app_key
    PUSHER_APP_SECRET=your_pusher_app_secret
    PUSHER_APP_CLUSTER=your_pusher_app_cluster
    ```

5. **Generate the application key:**

    ```bash
    php artisan key:generate
    ```

6. **Run database migrations:**

    ```bash
    php artisan migrate
    ```

7. **Run the development server:**

    ```bash
    php artisan serve
    ```

8. **Compile assets:**

    ```bash
    npm run dev
    ```

9. **Access the app:** Open your browser and go to `http://localhost:8000`.

## Usage

- **Host:** Create and manage tests and sessions, send invitations, monitor participants, and track results.
- **Participant:** Receive invitations, take tests, and receive real-time notifications.
- **Anti-Cheat:** Ensures fair test-taking by detecting cursor movements and enforcing time limits.

### Contributing
Contributions are welcome! Please submit a pull request or open an issue to discuss your ideas.
 
### Contact
For any inquiries, feel free to reach out to me at houssemmhiri95@gmail.com.
