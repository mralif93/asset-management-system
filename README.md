# 🏛️ Asset Management System for Masjid & Surau

A comprehensive web-based asset management system designed specifically for Malaysian mosques (Masjid) and prayer halls (Surau). Built with Laravel 12 and modern web technologies to provide efficient tracking and management of both movable and immovable assets.

## 🌟 Features

### 📊 **Dashboard & Analytics**
- **Admin Dashboard**: System-wide statistics and insights
- **User Dashboard**: Location-specific asset overview
- **Real-time Metrics**: Asset counts, values, and status tracking
- **Performance Indicators**: Asset utilization and maintenance schedules

### 👥 **User Management**
- **Role-based Access Control**: Admin and User roles
- **Separate Profile Systems**: Distinct interfaces for admins and users
- **Masjid/Surau Assignment**: Users linked to specific locations
- **Advanced User Controls**: Status management, password reset, bulk operations

### 🏢 **Location Management (Masjid/Surau)**
- **Comprehensive Database**: 25 fields including address, contact, and management details
- **Web Scraping Integration**: Automated data collection from e-masjid.jais.gov.my
- **Category Classification**: Kariah, Persekutuan, Negeri, Swasta, Wakaf
- **Geographic Information**: Multi-line addresses, postal codes, districts
- **Contact Management**: Phone, email, and responsible person details

### 📦 **Movable Asset Management**
- **Complete CRUD Operations**: Create, read, update, delete assets
- **Automatic Registration Numbers**: SOP-compliant unique identifiers
- **Asset Categorization**: Multiple asset types with abbreviations
- **Financial Tracking**: Acquisition costs, depreciation, useful life
- **Image Support**: Multiple photos per asset
- **Location Tracking**: Current placement and responsible officers
- **Status Management**: Active, maintenance, damaged states

### 🏠 **Immovable Asset Management**
- **Property Records**: Land and building documentation
- **Legal Information**: Title deeds, lot numbers, ownership details
- **Area Calculations**: Land and building measurements
- **Condition Monitoring**: Current state assessment
- **Cost Tracking**: Acquisition and maintenance expenses

### 🔄 **Asset Movement & Loans**
- **Movement Requests**: Formal application system
- **Approval Workflow**: Admin approval/rejection process
- **Location Tracking**: Source and destination logging
- **Return Management**: Expected and actual return dates
- **Loan Documentation**: Borrower details and responsibilities

### 🔍 **Inspection System**
- **Scheduled Inspections**: Regular asset condition checks
- **Detailed Reports**: Comprehensive inspection findings
- **Photo Documentation**: Visual condition records
- **Follow-up Actions**: Maintenance recommendations
- **Historical Tracking**: Inspection history and trends

### 🔧 **Maintenance Management**
- **Maintenance Records**: Detailed service documentation
- **Contractor Management**: Service provider information
- **Cost Tracking**: Maintenance expense monitoring
- **Scheduling**: Future maintenance planning
- **Status Updates**: Work progress tracking

### 🗑️ **Disposal & Write-off**
- **Disposal Requests**: Formal asset disposal process
- **Approval System**: Administrative oversight
- **Reason Documentation**: Detailed disposal justification
- **Value Assessment**: Asset disposal valuation
- **Document Management**: Supporting documentation storage

### 📈 **Reporting System**
- **Asset Summary Reports**: Comprehensive asset overviews
- **Financial Reports**: Value and depreciation analysis
- **Location-based Reports**: Assets by masjid/surau
- **Maintenance Schedules**: Upcoming service requirements
- **Movement History**: Asset transfer tracking
- **Custom Filters**: Date ranges, categories, locations

### 🔒 **Security & Audit**
- **Comprehensive Audit Trail**: All system activities logged
- **User Activity Tracking**: Login, logout, and action monitoring
- **Role-based Permissions**: Granular access control
- **Data Integrity**: Validation and verification systems
- **Secure File Uploads**: Image and document management

## 🛠️ Technology Stack

### **Backend**
- **Framework**: Laravel 12.x
- **PHP Version**: 8.2+
- **Database**: SQLite (development), MySQL/PostgreSQL (production)
- **Authentication**: Laravel Breeze
- **File Storage**: Laravel Storage with public disk

### **Frontend**
- **CSS Framework**: Tailwind CSS
- **JavaScript**: Alpine.js for interactivity
- **Build Tool**: Vite
- **Icons**: Heroicons
- **UI Components**: Custom Blade components

### **Additional Libraries**
- **Web Scraping**: Symfony DomCrawler
- **Image Processing**: GD/Imagick extension
- **PDF Generation**: Built-in Laravel capabilities
- **HTTP Client**: Laravel HTTP Client (Guzzle)

## 📋 Requirements

- **PHP**: 8.2 or higher
- **Composer**: Latest version
- **Node.js**: 18+ with npm
- **Database**: SQLite/MySQL/PostgreSQL
- **Web Server**: Apache/Nginx
- **PHP Extensions**: GD, PDO, Mbstring, OpenSSL, Tokenizer, XML, Ctype, JSON

## 🚀 Installation

### 1. **Clone Repository**
```bash
git clone https://github.com/your-username/asset-management-system.git
cd asset-management-system
```

### 2. **Install Dependencies**
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. **Environment Setup**
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env file
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

### 4. **Database Setup**
```bash
# Create SQLite database file
touch database/database.sqlite

# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

### 5. **Storage Setup**
```bash
# Create storage link
php artisan storage:link

# Set permissions
chmod -R 775 storage bootstrap/cache
```

### 6. **Build Assets**
```bash
# Development
npm run dev

# Production
npm run build
```

### 7. **Start Development Server**
```bash
# Start Laravel server
php artisan serve

# Or use the combined development command
composer run dev
```

## 👤 Default Users

After seeding, the following users are available:

### **Admin User**
- **Email**: admin@example.com
- **Password**: password
- **Role**: Administrator
- **Access**: Full system access

### **Regular User**
- **Email**: user@example.com
- **Password**: password
- **Role**: User
- **Access**: Location-specific access

## �� Usage Guide

### **Getting Started**
1. **Login** with admin credentials
2. **Create Locations** (Masjid/Surau) or run the seeder
3. **Add Users** and assign them to locations
4. **Register Assets** (movable and immovable)
5. **Set up Inspection** and maintenance schedules
6. **Configure Reports** as needed

### **Asset Registration**
1. Navigate to **Assets** → **Add New Asset**
2. Select the **Masjid/Surau** location
3. Fill in **asset details** (name, type, acquisition info)
4. Upload **asset images**
5. Set **location and responsible officer**
6. System **automatically generates** registration number

## 📊 Database Schema

### **Core Tables**
- **masjid_surau**: Location information (25 fields)
- **users**: User accounts and roles
- **assets**: Movable asset records
- **immovable_assets**: Property and land records
- **asset_movements**: Movement and loan tracking
- **inspections**: Asset inspection records
- **maintenance_records**: Service and repair logs
- **disposals**: Asset disposal records
- **loss_writeoffs**: Loss and write-off documentation
- **audit_trails**: System activity logs

### **Key Relationships**
- Users belong to Masjid/Surau
- Assets belong to Masjid/Surau
- Movements, Inspections, Maintenance linked to Assets
- Comprehensive audit trail for all entities

## 🧪 Testing

### **Run Tests**
```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

## 🚀 Deployment

### **Production Deployment**
1. **Server Setup**: Configure web server (Apache/Nginx)
2. **Environment**: Set production environment variables
3. **Database**: Set up production database
4. **Optimization**: Cache configuration and routes
5. **Security**: Set proper file permissions
6. **SSL**: Configure HTTPS certificates

### **Optimization Commands**
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

## 🤝 Contributing

We welcome contributions to improve the Asset Management System:

### **Development Process**
1. **Fork** the repository
2. **Create** a feature branch
3. **Make** your changes
4. **Add** tests for new functionality
5. **Submit** a pull request

### **Coding Standards**
- Follow **PSR-12** coding standards
- Use **Laravel** best practices
- Write **comprehensive tests**
- Document **new features**
- Maintain **backward compatibility**

## 📝 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

### **Documentation**
- **Laravel Documentation**: [https://laravel.com/docs](https://laravel.com/docs)
- **Tailwind CSS**: [https://tailwindcss.com/docs](https://tailwindcss.com/docs)
- **Alpine.js**: [https://alpinejs.dev](https://alpinejs.dev)

### **Getting Help**
- **Issues**: Report bugs and request features via GitHub Issues
- **Discussions**: Join community discussions
- **Documentation**: Check the wiki for detailed guides

## 🏗️ Project Structure

```
asset-management-system/
├── app/
│   ├── Http/Controllers/     # Request handling
│   │   ├── Admin/           # Admin controllers
│   │   ├── Auth/            # Authentication
│   │   └── User/            # User controllers
│   ├── Models/              # Eloquent models
│   ├── Services/            # Business logic
│   ├── Traits/              # Reusable traits
│   └── Helpers/             # Helper classes
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/            # Data seeders
│   └── factories/          # Model factories
├── resources/
│   ├── views/              # Blade templates
│   │   ├── admin/          # Admin interface
│   │   ├── user/           # User interface
│   │   └── layouts/        # Layout templates
│   ├── css/                # Stylesheets
│   └── js/                 # JavaScript files
├── routes/
│   ├── web.php             # Web routes
│   ├── auth.php            # Authentication routes
│   └── console.php         # Console commands
└── public/                 # Public assets
```

## 📈 Roadmap

### **Upcoming Features**
- [ ] **Mobile Application**: React Native/Flutter app
- [ ] **API Development**: RESTful API for integrations
- [ ] **Advanced Reporting**: Charts and analytics
- [ ] **Notification System**: Email and SMS alerts
- [ ] **Multi-language Support**: Bahasa Malaysia and English
- [ ] **Barcode Integration**: QR code generation and scanning
- [ ] **Advanced Search**: Full-text search capabilities
- [ ] **Data Export**: Excel, PDF, and CSV export options

### **Technical Improvements**
- [ ] **Performance Optimization**: Database indexing and caching
- [ ] **Security Enhancements**: Advanced authentication methods
- [ ] **Test Coverage**: Comprehensive test suite
- [ ] **Documentation**: API documentation and user guides
- [ ] **CI/CD Pipeline**: Automated testing and deployment

---

## 📊 System Statistics

- **Total Models**: 10+ Eloquent models
- **Controllers**: 15+ feature controllers
- **Database Tables**: 12+ tables with relationships
- **Views**: 50+ Blade templates
- **Migrations**: Organized, comprehensive structure
- **Features**: Complete asset lifecycle management
- **Roles**: Multi-level user access control
- **Security**: Comprehensive audit trail system

Built with ❤️ for Malaysian Masjid and Surau communities.
