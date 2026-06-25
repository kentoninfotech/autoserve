# AUTOSERVE ERP SYSTEM
## User Guide & Standard Operating Procedures (SOP)

---

## 📋 TABLE OF CONTENTS

1. [System Overview](#system-overview)
2. [Getting Started](#getting-started)
3. [Navigation Guide](#navigation-guide)
4. [Detailed Procedures by Role](#detailed-procedures-by-role)
5. [Common Tasks (Step-by-Step)](#common-tasks-step-by-step)
6. [Troubleshooting Guide](#troubleshooting-guide)
7. [Best Practices](#best-practices)
8. [FAQ](#faq)

---

## 1. SYSTEM OVERVIEW

### What is AutoServe ERP?

AutoServe ERP is a comprehensive business management system designed for automotive service centers. It integrates all business functions including customer management, job tracking, inventory, payments, and reporting into one unified platform.

### System Architecture

```
┌────────────────────────────────────────────────────────────┐
│                      LOGIN PAGE                            │
│          (Enter Username & Password)                       │
└────────────────────────────────────────────────────────────┘
                            ↓
┌────────────────────────────────────────────────────────────┐
│                      DASHBOARD                             │
│              (Home - Welcome Screen)                       │
│     • Performance Charts                                   │
│     • Quick Action Buttons                                 │
│     • Notifications & Alerts                               │
└────────────────────────────────────────────────────────────┘
                            ↓
         ┌──────────────────┼──────────────────┐
         │                  │                  │
         ▼                  ▼                  ▼
    ┌─────────┐      ┌────────────┐    ┌──────────┐
    │CUSTOMERS│      │    JOBS    │    │ PAYMENTS │
    │VEHICLES │      │  VEHICLES  │    │FINANCES  │
    └─────────┘      └────────────┘    └──────────┘
         │                  │                  │
         └──────────────────┼──────────────────┘
                            │
         ┌──────────────────┼──────────────────┐
         │                  │                  │
         ▼                  ▼                  ▼
    ┌─────────┐      ┌────────────┐    ┌──────────┐
    │INVENTORY│      │  REPORTS   │    │SETTINGS  │
    │SUPPLIES │      │ANALYTICS   │    │ADMIN     │
    └─────────┘      └────────────┘    └──────────┘
```

---

## 2. GETTING STARTED

### 2.1 INITIAL LOGIN

**Step 1:** Navigate to AutoServe URL
```
https://your-domain.com or http://127.0.0.1:8000
```

**Step 2:** Enter Your Credentials
- **Username:** [Provided by Administrator]
- **Password:** [Your initial password]

**Step 3:** Click "Login" Button

**Step 4:** First Login Actions
- Dashboard appears with welcome message
- Update your profile (optional)
- Review security settings
- Set password reminder

### 2.2 SETTING UP YOUR PROFILE

**Accessing Profile:**
1. Click on your name (Top Right Corner) → "My Profile"
2. Review your information
3. Update profile photo (optional)
4. Verify contact details
5. Click "Save"

**Changing Password:**
1. Click on your name → "My Profile"
2. Find "Change Password" section
3. Enter current password
4. Enter new password (min 8 characters, mixed case)
5. Confirm new password
6. Click "Update Password"

### 2.3 UNDERSTANDING THE INTERFACE

**Top Navigation Bar:**
- **Logo/Company Name** - Click to return to dashboard
- **Search Bar** - Search customers, jobs, organizations
- **Cart Icon** - For car sales (if applicable)
- **Notifications** - View alerts and reminders
- **User Menu** - Profile, settings, logout

**Left Sidebar:**
- **Dashboard** - Home page
- **Customers** - Customer management
- **Jobs** - Job management
- **Payments** - Financial management
- **Sales/Inventory** - Parts and car sales
- **Post Service** - Follow-up management
- **Communication** - SMS and tasks
- **Settings** - System configuration

**Main Content Area:**
- Displays selected module content
- Tables, forms, and data entry
- Buttons for actions (Add, Edit, Delete)
- Filters and search options

---

## 3. NAVIGATION GUIDE

### 3.1 MAIN MENU STRUCTURE

```
DASHBOARD
├── Performance Analytics
├── Quick Action Buttons
├── Notifications
└── Business Statistics

CUSTOMERS
├── Add New Customer
├── All Customers (List/Search)
├── Edit Customer
├── Customer Vehicles
├── Customer Jobs
└── Merge Duplicate Contacts

JOBS
├── New Job
├── Pending Jobs
├── Completed Jobs
├── Edit Job
├── Job Instructions
├── Invoices (Invoice/Receipt/Estimate)
└── Job Gallery

VEHICLES
├── All Vehicles
├── Edit Vehicle
├── Vehicle Jobs
└── Vehicle Service History

SALES & INVENTORY
├── Sales
├── New Sales
├── Parts Management
├── Supplies Management
├── Car Inventory
└── Car Sales Orders

PAYMENTS
├── New Payment
├── Payments List
├── Debtors
├── Transactions
└── Account Heads

JOB CONTROLS
├── Assign Jobs to Technicians
├── Print Job Controls
└── Attendance

POST SERVICE
├── Post Service Follow-ups
├── PSFU Reports
└── Reminders

COMMUNICATION
├── Send SMS
├── Sent Messages
├── Tasks/Reminders
└── New Task

SETTINGS
├── Account Settings
├── Personnel Management
├── Users Management
├── Bank Accounts
├── System Backup
└── Company Settings
```

### 3.2 ACCESSING COMMON FEATURES

**Quick Search:** Use search bar at top
- Type customer name, organization, or job number
- Press Enter or click "Go"
- View filtered results

**Back Button:** Browser back or sidebar link

**Filter Options:** Available on most list pages
- By date range
- By status
- By customer
- By amount

**Action Buttons:**
- **Add** - Create new record
- **Edit** - Modify existing record
- **Delete** - Remove record (with confirmation)
- **View** - Open details
- **Print** - Print document
- **Export** - Save as Excel/PDF

---

## 4. DETAILED PROCEDURES BY ROLE

### 4.1 FRONT-DESK STAFF PROCEDURES

#### Role Purpose
Front-desk staff handles customer interactions, job creation, and customer service.

#### Daily Checklist

- [ ] Log in to system
- [ ] Check dashboard for pending tasks
- [ ] Review today's appointments
- [ ] Process any overnight phone messages
- [ ] Start day operations

#### Procedure 1: ADDING A NEW CUSTOMER

**Scenario:** A customer calls to schedule service for their vehicle

**Step 1:** Navigate to Add New Customer
- Click "Customers" (Left Sidebar)
- Select "Add New Customer"

**Step 2:** Enter Customer Information
- **Customer Name:** [Full Name] *(Required)*
- **Organization:** [Company Name if applicable]
- **Phone Number:** [Primary Contact]
- **Email:** [Email Address]
- **Address:** [Full Address]
- **Customer ID:** [Auto-generated - do NOT change]

**Step 3:** Vehicle Information (Optional - can add later)
- **Vehicle Registration No:** [Reg Number]
- **Make/Model:** [Vehicle Type]
- **Chassis Number:** [VIN or Chasis Number]
- **Engine Type:** [Engine specifications]

**Step 4:** Additional Information
- **Source:** [How customer found you]
- **Notes:** [Any special requirements]

**Step 5:** Save Customer
- Click "Save Customer" Button
- System displays confirmation message
- Customer ID is generated and displayed

**Tip:** Save basic information now, collect vehicle details later if needed.

#### Procedure 2: CREATING A NEW JOB

**Scenario:** Customer arrives or calls with vehicle service request

**Step 1:** Navigate to New Job
- Click "Jobs" (Left Sidebar)
- Select "New Job"

**Step 2:** Select or Add Customer
- Option A: Search existing customer
  - Type name in search box
  - Select from dropdown
  - Click "Select Customer"
  
- Option B: Create new customer
  - Click "Add New Customer"
  - Complete customer form (See Procedure 1)

**Step 3:** Select Vehicle
- Search customer's vehicles
- Select vehicle from list
- If vehicle not listed: Click "Add Vehicle" to create new

**Step 4:** Enter Job Information
- **Job Type/Description:** [Nature of service]
  - Examples: General Service, Repairs, Maintenance
  - Custom description as needed

- **Odometer Reading:** [Current vehicle mileage]
  - Important for maintenance tracking

- **Job Description:** [Detailed problem description]
  - Customer complaint summary
  - Work required
  - Special instructions

**Step 5:** Initial Diagnosis (Optional - can add later)
- **Problems Identified:** [List issues found]
- **Causes:** [Root cause analysis]
- **Owner's Request:** [Specific customer requests]

**Step 6:** Create Job
- Click "Create Job" Button
- Job number is auto-generated
- Job moves to "Pending Jobs" list

**Step 7:** Notify Technician
- Print job instruction card
- Post on technician board
- Or assign to specific technician (Job Controls)

**Tip:** More details can be added later as work progresses.

#### Procedure 3: PROCESSING A PAYMENT

**Scenario:** Customer brings payment for completed job

**Step 1:** Locate the Invoice/Job
- Use search bar at top
- Search by invoice number or job number
- Review job details and amount

**Step 2:** Navigate to New Payment
- From job details, click "Make Payment"
- Or go to "Payments" → "New Payment"
- Enter invoice number

**Step 3:** Enter Payment Details
- **Amount Paid:** [Amount received]
- **Payment Method:** 
  - Cash
  - Cheque
  - Transfer
  - Card
  - Other

- **Date of Payment:** [Today's date]
- **Reference Number:** [Cheque #, Transfer ref, etc.]

**Step 4:** Record Payment
- Click "Record Payment" Button
- System generates receipt
- Payment is recorded in system

**Step 5:** Provide Customer Receipt
- Print receipt from system
- Give to customer
- Keep copy for records

**Tip:** Always verify amount matches invoice before processing.

#### Procedure 4: SENDING CUSTOMER SMS

**Scenario:** Need to notify customer of job completion

**Step 1:** Navigate to Communications
- Click "Communication" (Left Sidebar)
- Select "Send SMS Messages"

**Step 2:** Select Recipients
- Option A: Single customer
  - Type customer name
  - Select from dropdown
  
- Option B: Multiple customers
  - Use checkboxes to select multiple
  - Or use "Select All" for bulk messages

**Step 3:** Compose Message
- Click in message box
- Type your message
- Keep under 160 characters per message
- Character counter shows remaining space

**Step 4:** Select Template (Optional)
- Use SMS template if available
- Modify as needed
- Or write custom message

**Step 5:** Send SMS
- Click "Send SMS" Button
- Confirmation appears
- Message sent to customer

**Step 6:** Verify Delivery
- Go to "Sent Messages"
- Confirm message in list
- View delivery status

**Tip:** Save common messages as templates for faster sending.

#### Procedure 5: RECORDING A TASK/REMINDER

**Scenario:** Need to create reminder for follow-up or action

**Step 1:** Navigate to Tasks
- Click "Communication" → "Tasks"
- Or click "New Task" button

**Step 2:** Enter Task Details
- **Task Title:** [Brief description of task]
- **Description:** [Detailed task information]
- **Due Date:** [When task should be done]
- **Priority:** [High/Medium/Low]

**Step 3:** Save Task
- Click "Create Task" Button
- Task appears in task list
- System shows notification

**Step 4:** Update Task Status
- In task list, find your task
- Mark as "In Progress" when starting
- Mark as "Completed" when done
- Delete when obsolete

**Tip:** Regular tasks can be assigned to specific team members.

### 4.2 FINANCE/CASHIER STAFF PROCEDURES

#### Role Purpose
Finance staff handles payments, transactions, financial tracking, and reporting.

#### Daily Checklist

- [ ] Log in to system
- [ ] Review payments due today
- [ ] Check outstanding receivables
- [ ] Process today's payments
- [ ] Record transactions
- [ ] End-of-day reconciliation

#### Procedure 1: RECORDING A FINANCIAL TRANSACTION

**Scenario:** Purchasing supplies or recording business income

**Step 1:** Navigate to Transactions
- Click "Payments" → "Transactions"
- Click "Add Transaction"

**Step 2:** Enter Transaction Details
- **Transaction Type:**
  - Income (Money in)
  - Expense (Money out)

- **Date:** [When transaction occurred]
- **Amount:** [Transaction amount]

**Step 3:** Categorize Transaction
- **Account Head:** [Select appropriate category]
  - Examples: Service Revenue, Supply Purchase, Utilities, etc.
  - System maintains list of valid categories

**Step 4:** Enter Additional Information
- **Reference Number:** [Invoice#, Cheque#, Receipt#, etc.]
- **Description:** [Details of transaction]
- **Payee/Source:** [Who paid or received payment]

**Step 5:** Record Transaction
- Click "Save Transaction" Button
- Transaction recorded in system
- Appears in financial reports

#### Procedure 2: VIEWING DEBTORS (OUTSTANDING PAYMENTS)

**Scenario:** Manager wants to know who owes money

**Step 1:** Navigate to Debtors
- Click "Payments" → "Debtors"

**Step 2:** Review Outstanding Receivables
- See list of customers with unpaid invoices
- Shows:
  - Customer name
  - Outstanding amount
  - Number of unpaid invoices
  - Oldest debt date

**Step 3:** Generate Reminder
- Identify customers needing follow-up
- Make note of amounts
- Create SMS reminder to customer

**Step 4:** Record Payment When Received
- See Procedure 3 from Front-Desk section
- Payment clears outstanding balance
- Customer removed from debtors list

#### Procedure 3: MANAGING ACCOUNT HEADS

**Scenario:** Need to add new expense category

**Step 1:** Navigate to Account Heads
- Click "Payments" → "Account Heads"

**Step 2:** View Existing Account Heads
- See all active categories
- Shows:
  - Category name
  - Category type (Income/Expense)
  - Description
  - Total amounts

**Step 3:** Add New Account Head
- Click "Add Account Head" Button
- Enter account name
- Select type (Income or Expense)
- Enter description
- Click "Save"

**Step 4:** Use in Transactions
- New account head available in transaction dropdowns
- Use when recording relevant transactions
- Improves financial categorization

#### Procedure 4: GENERATING FINANCIAL REPORTS

**Scenario:** Manager needs monthly financial summary

**Step 1:** Navigate to Reports
- Click "Payments" → "Reports" or use main "Reports" menu

**Step 2:** Select Report Type
- **Income Report** - All revenue
- **Expense Report** - All costs
- **Profit & Loss** - Summary
- **Transaction Report** - Detailed list

**Step 3:** Set Report Parameters
- **Date Range:** Select start and end dates
- **Account Head:** Filter by category (optional)
- **Filter Type:** Income/Expense

**Step 4:** Generate Report
- Click "Generate Report" Button
- System creates formatted report
- Shows summary and details

**Step 5:** Export or Print
- Click "Export to Excel" - saves as .xlsx file
- Click "Print to PDF" - creates PDF document
- Save to computer for records/analysis

**Tip:** Schedule regular reports (weekly/monthly) for consistent monitoring.

#### Procedure 5: PROCESSING BULK PAYMENTS

**Scenario:** Paying multiple suppliers or invoices at once

**Step 1:** Gather Invoice List
- Collect all invoices to be paid
- Verify amounts and details
- Group by payment method

**Step 2:** Record Individual Payments
- For each invoice, follow "Processing a Payment" procedure
- Or use bulk import if available

**Step 3:** Generate Payment Register
- Print payment list for approval
- Shows all recorded payments
- Total payment amount

**Step 4:** Reconcile with Bank
- Match recorded payments to bank statement
- Verify amounts match
- Note any discrepancies

**Step 5:** Archive Records
- Save payment register
- File invoice copies
- Backup electronic records

### 4.3 TECHNICIAN/MECHANIC PROCEDURES

#### Role Purpose
Technicians perform vehicle service and repairs, document work, and update job status.

#### Daily Checklist

- [ ] Log in to system (if using web access)
- [ ] Check assigned jobs
- [ ] Review job instructions
- [ ] Track parts used
- [ ] Update job progress
- [ ] Complete job documentation

#### Procedure 1: VIEWING ASSIGNED JOBS

**Scenario:** Start of day - need to see today's workload

**Step 1:** Navigate to Job Controls
- Click "Job Controls" (Left Sidebar)
- Or check printed job sheet

**Step 2:** View Your Assigned Jobs
- Filter by technician (you)
- View jobs assigned to you
- Review job details:
  - Vehicle information
  - Customer requirements
  - Diagnosis/Problems
  - Parts available

**Step 3:** Prioritize Work
- Review job complexity
- Check time estimates
- Plan work sequence
- Get required parts

**Step 4:** Access Job Documentation
- Open job details
- Read complete description
- Review customer requests
- Print job card if needed

#### Procedure 2: RECORDING PARTS USED

**Scenario:** Using parts for current job

**Step 1:** Navigate to Current Job
- Find job in system
- Open job details
- Go to "Parts" tab

**Step 2:** Add Parts Used
- Click "Add Parts" Button
- Select part from list
  - Search by part name
  - Or browse inventory
  
- Enter quantity used
- System shows part price
- Amount auto-calculated

**Step 3:** Continue Adding Parts
- For each part used, repeat above
- Click "Add More Parts" for additional items
- System maintains running total

**Step 4:** Review Parts List
- Verify all parts recorded
- Check quantities
- Confirm amounts
- Review total parts cost

**Step 5:** Save Parts Record
- Click "Save" Button
- Parts deducted from inventory
- Job cost updated

**Tip:** Record parts immediately after use to maintain accuracy.

#### Procedure 3: UPDATING JOB PROGRESS

**Scenario:** Job completion status needs updating

**Step 1:** Open Current Job
- Find job in "Pending Jobs"
- Click to open details

**Step 2:** Update Diagnosis Tab
- Add any additional findings
- Update "Problems" field with solutions applied
- Note any unexpected issues
- Record technician notes

**Step 3:** Update Status Notes
- In job description area, add progress notes
- Note time spent
- Document any delays
- Update customer communication

**Step 4:** Mark Job Completion
- When work is finished:
  - Verify all parts recorded
  - Verify all work complete
  - Quality check performed
  
- Click "Mark as Complete"
- Job moves to "Completed Jobs"

**Step 5:** Submit for Quality Control
- Notify supervisor job is complete
- Provide before/after documentation
- Highlight any issues resolved
- Await quality approval

**Tip:** Complete documentation immediately after work to avoid forgetting details.

#### Procedure 4: RECORDING LABOR CHARGES

**Scenario:** Labor time needs recording for billing

**Step 1:** Open Job Details
- Find completed job
- Go to "Financials" tab

**Step 2:** Enter Labor Charges
- Click in "Labour Cost" field
- Enter labor amount
  - Based on hourly rate × hours worked
  - Or flat rate for service type
  
- System auto-calculates if hourly rate stored

**Step 3:** Add Service Description
- In "Services" section
- Add labor service entry
- Describe work performed
- Enter service cost

**Step 4:** Verify Total
- Check total job cost calculation
- Confirm parts + labor + sundries
- Apply discount if applicable
- Verify VAT calculation

**Step 5:** Save Job
- Click "Save" to finalize
- Invoice ready for generation
- Ready for customer billing

**Tip:** Record labor charges same day while work details are fresh.

### 4.4 INVENTORY/SPARE-PARTS MANAGER PROCEDURES

#### Role Purpose
Manage parts inventory, supplies, and stock levels.

#### Daily Checklist

- [ ] Log in to system
- [ ] Review low stock items
- [ ] Process new inventory received
- [ ] Update parts prices
- [ ] Monitor usage trends
- [ ] Generate stock reports

#### Procedure 1: ADDING NEW PARTS TO INVENTORY

**Scenario:** Received new stock of parts from supplier

**Step 1:** Navigate to Parts
- Click "Sales/Inventory" → "Parts"
- Click "Add Part"

**Step 2:** Enter Part Information
- **Part Name:** [Description of part]
  - Example: "Brake Pads - Front Set"
  
- **Part Number:** [Manufacturer part number]
  - For easy identification
  - Important for ordering

- **Description:** [Additional details]
  - Specifications
  - Compatibility info
  - Warnings/Notes

**Step 3:** Set Pricing
- **Cost Price:** [Amount paid to supplier]
- **Selling Price:** [Price charged to customers]
- **Quantity in Stock:** [Number of units received]

**Step 4:** Set Reorder Information
- **Minimum Stock Level:** [When to reorder]
- **Reorder Quantity:** [Standard order amount]
- **Supplier:** [Where purchased]

**Step 5:** Save Part
- Click "Save Part" Button
- Part added to inventory
- Available for selection in jobs

**Tip:** Use consistent naming and part numbers for easy searching.

#### Procedure 2: UPDATING INVENTORY WHEN PARTS USED

**Scenario:** Parts used in a job need inventory adjustment

**Step 1:** Monitor Job Completions
- Check completed jobs daily
- Review parts used

**Step 2:** Verify Stock Adjustment
- When technician records parts in job
- System automatically deducts from inventory
- Check "Inventory" → "Parts"
- Verify quantities match

**Step 3:** Restock When Low
- Monitor stock levels
- When below minimum, order
- Update part record with reorder

**Step 4:** Receive and Update Stock
- Receive stock from supplier
- Update part quantity
- Click "Edit Part" → update quantity
- Save changes

**Step 5:** Monitor Fast-Moving Items
- Review usage trends
- Identify high-use items
- Ensure adequate stock
- Adjust reorder quantities

**Tip:** Review inventory weekly to catch issues early.

#### Procedure 3: MANAGING CAR INVENTORY

**Scenario:** New vehicles received for resale

**Step 1:** Navigate to Car Inventory
- Click "Sales/Inventory" → "Car Inventory"
- Click "Add Vehicle"

**Step 2:** Enter Vehicle Details
- **Make and Model:** [Vehicle type]
- **Registration Number:** [Reg No]
- **Chassis Number:** [VIN]
- **Year:** [Year of manufacture]
- **Engine Type:** [Engine specs]
- **Color:** [Vehicle color]
- **Mileage:** [Current odometer reading]

**Step 3:** Set Pricing
- **Cost Price:** [Amount paid]
- **Asking Price:** [Price for sale]
- **Discount Available:** [Any promotional discounts]

**Step 4:** Upload Vehicle Images
- Click "Upload Images"
- Select 3-5 high-quality photos
  - Front view
  - Side view
  - Interior view
  - Engine view
  - Detailed features

**Step 5:** Set Thumbnail
- Select best image for thumbnail
- This appears in listing
- Should be professional/attractive

**Step 6:** Save Vehicle
- Click "Save Vehicle" Button
- Vehicle added to inventory
- Ready for customer viewing

**Step 7:** Update Inventory
- When vehicle sells
- Edit vehicle record
- Mark as "Sold"
- Update status

**Tip:** Use high-quality images for better sales.

#### Procedure 4: REVIEWING INVENTORY REPORTS

**Scenario:** Manager needs stock level report

**Step 1:** Navigate to Inventory Reports
- Click "Reports" → "Inventory"
- Select "Stock Report"

**Step 2:** Generate Report
- Select date range
- Filter by part category (optional)
- Click "Generate Report"

**Step 3:** Review Stock Status
- Show current quantities
- Compare to minimum levels
- Identify overstocking
- Identify low stock items

**Step 4:** Identify Reorder Needs
- Parts below minimum noted
- Urgent orders identified
- Regular orders listed

**Step 5:** Create Purchase Orders
- Document items to order
- Contact suppliers
- Record quantities needed
- Note delivery dates

**Step 6:** Export Report
- Save as Excel file
- Print for filing
- Share with team

---

## 5. COMMON TASKS (STEP-BY-STEP)

### TASK 1: CREATE COMPLETE JOB FROM START TO INVOICE

**Time Required:** 10-15 minutes
**Required Information:** Customer details, vehicle info, service description

**Step 1:** Add Customer (if new)
```
Customers → Add New Customer
├─ Enter name, phone, email, address
├─ Enter organization
├─ Click Save
└─ Note customer ID
```

**Step 2:** Add Vehicle (if new)
```
Vehicles → Add Vehicle
├─ Enter reg number, make, model
├─ Enter chassis number
├─ Enter engine type
└─ Click Save
```

**Step 3:** Create Job
```
Jobs → New Job
├─ Select customer
├─ Select vehicle
├─ Enter job description
├─ Enter mileage reading
├─ Click Create Job
└─ Note job number
```

**Step 4:** Add Parts
```
Edit Job → Parts Tab
├─ Click Add Parts
├─ Search and select parts
├─ Enter quantities
├─ Click Save Parts
└─ Review total parts cost
```

**Step 5:** Add Services
```
Edit Job → Services Tab
├─ Add services provided
├─ Enter descriptions
├─ Click Save Services
└─ Verify service list
```

**Step 6:** Record Labor
```
Edit Job → Financials Tab
├─ Enter labor charges
├─ Add labor description
├─ Verify calculations
└─ Click Save
```

**Step 7:** Generate Invoice
```
Jobs → Select Job → Print Invoice
├─ Choose invoice type
├─ Verify all details
├─ Click Print/PDF
└─ Save or print for customer
```

**Step 8:** Process Payment
```
Payments → New Payment
├─ Enter invoice number
├─ Enter amount received
├─ Select payment method
├─ Click Save Payment
└─ Generate receipt
```

**Step 9:** Complete Job
```
Edit Job → Mark as Complete
├─ Verify all information
├─ Final quality check
├─ Click Complete
└─ Archive in completed jobs
```

---

### TASK 2: FOLLOW UP WITH CUSTOMER AFTER SERVICE

**Time Required:** 5-10 minutes per customer
**Required Information:** Customer phone, job details

**Step 1:** Prepare Follow-up Information
```
Find Customer Job
├─ Note job number
├─ Review work performed
├─ Note any recommendations
└─ Prepare message
```

**Step 2:** Send SMS to Customer
```
Communication → Send SMS
├─ Select customer
├─ Type message thanking for business
├─ Include job number reference
├─ Click Send SMS
└─ Confirm sent
```

**Step 3:** Schedule Follow-up Task
```
Communication → New Task
├─ Enter follow-up task
├─ Set due date (e.g., 30 days)
├─ Assign to responsible person
├─ Click Save Task
└─ Confirm in task list
```

**Step 4:** Record in PSFU
```
Post Service → Add Follow-up
├─ Link to customer and job
├─ Note follow-up method (SMS)
├─ Record date/time
├─ Enter notes
└─ Mark as complete
```

**Step 5:** Create Reminder
```
Communication → Tasks
├─ Set reminder for next contact
├─ Assign responsible person
├─ Click Save
└─ Confirm reminder active
```

---

### TASK 3: GENERATE MONTHLY BUSINESS REPORT

**Time Required:** 20-30 minutes
**Required Information:** Month and year to report

**Step 1:** Gather Revenue Data
```
Jobs → Completed Jobs
├─ Filter by date range (month)
├─ Note total jobs
├─ Calculate total revenue
└─ Note average job value
```

**Step 2:** Gather Expense Data
```
Payments → Transactions
├─ Filter by date range
├─ Select expense category
├─ Generate report
├─ Export to Excel
└─ Calculate total expenses
```

**Step 3:** Generate Profit Report
```
Reports → Financial Reports
├─ Select Profit & Loss
├─ Choose month
├─ Generate report
└─ Review calculations
```

**Step 4:** Compile Performance Metrics
```
Dashboard → Performance Analytics
├─ Jobs completed this month
├─ Average technician productivity
├─ Customer satisfaction
├─ Parts sales if applicable
└─ Note trends
```

**Step 5:** Create Summary Document
```
Export All Reports
├─ Save to Excel/Word
├─ Create month summary
├─ Include key metrics
├─ Include charts/graphs
└─ Save for records
```

**Step 6:** Share with Management
```
Distribution
├─ Email reports
├─ Schedule review meeting
├─ Present findings
├─ Discuss improvements
└─ Archive report
```

---

### TASK 4: CONDUCT MONTH-END INVENTORY CHECK

**Time Required:** 60-90 minutes
**Required Information:** Current inventory quantities

**Step 1:** Pull Current Inventory List
```
Reports → Inventory → Stock Report
├─ Generate full inventory list
├─ Export to Excel
├─ Print for physical count
└─ Note all items
```

**Step 2:** Physical Count
```
Warehouse Inventory Counting
├─ Count each item physically
├─ Record counts on printout
├─ Note discrepancies
├─ Investigate unusual amounts
└─ Complete count
```

**Step 3:** Compare with System
```
Review Discrepancies
├─ Compare physical vs system
├─ Note differences
├─ Investigate causes:
│  ├─ Unrecorded usage
│  ├─ Theft/loss
│  ├─ Ordering errors
│  └─ Data entry errors
└─ Document findings
```

**Step 4:** Adjust Inventory
```
Update System if Needed
├─ For each discrepancy
├─ Edit part quantity
├─ Add adjustment note
├─ Record reason
├─ Click Save
└─ Generate adjustment report
```

**Step 5:** Identify Low Stock Items
```
Analysis
├─ Items below minimum
├─ Fast-moving items
├─ Slow-moving items
├─ Obsolete items
└─ Create reorder list
```

**Step 6:** Create Purchase Orders
```
Order Management
├─ For items needing reorder
├─ Calculate quantities
├─ Contact suppliers
├─ Record order information
└─ Set delivery date reminder
```

**Step 7:** Document Results
```
Report Generation
├─ Create inventory report
├─ Show variances
├─ Recommendations
├─ Approval signature
└─ Archive report
```

---

## 6. TROUBLESHOOTING GUIDE

### Common Issues and Solutions

#### ISSUE: Cannot Log In

**Problem:** Username or password not working

**Solutions:**
1. **Verify Credentials**
   - Check username spelling
   - Ensure Caps Lock is off
   - Verify correct user account

2. **Password Reset**
   - Click "Forgot Password" link
   - Enter email address
   - Follow password reset link
   - Create new password
   - Try logging in again

3. **Account Locked**
   - After 5 failed attempts, account may lock
   - Contact administrator
   - Request password reset
   - Wait 30 minutes for automatic unlock

4. **Browser Issues**
   - Clear browser cache
   - Try different browser
   - Disable VPN/proxy
   - Check internet connection

---

#### ISSUE: Search Not Finding Results

**Problem:** Customer/Job not appearing in search

**Solutions:**
1. **Check Search Term**
   - Exact name needed (not abbreviation)
   - Check spelling
   - Try partial search
   - Use different search field

2. **Verify Record Exists**
   - Navigate to list view (not search)
   - Browse manually
   - Check if recently added
   - Confirm not deleted

3. **Clear Search Cache**
   - Refresh browser (F5)
   - Clear browser cache
   - Try new search
   - Check if results appear

4. **Administrator Help**
   - If still not finding
   - Contact admin
   - Check system logs
   - Verify record permissions

---

#### ISSUE: PDF or Invoice Not Generating

**Problem:** Print to PDF fails or document not created

**Solutions:**
1. **Check Required Information**
   - All job fields completed
   - Customer details entered
   - Parts/services recorded
   - All calculations done

2. **Browser Issue**
   - Try different browser
   - Update browser version
   - Disable popup blockers
   - Enable JavaScript

3. **File Permission**
   - Check storage space
   - Verify folder permissions
   - Check antivirus blocking
   - Try different location

4. **System Issue**
   - Contact administrator
   - Check system logs
   - Report issue with details
   - Try again later

---

#### ISSUE: Payment Not Recording

**Problem:** Payment recorded but not showing in system

**Solutions:**
1. **Verify Entry**
   - Correct invoice selected?
   - Correct amount entered?
   - Proper payment method?
   - Correct date?

2. **Refresh System**
   - Refresh browser page (F5)
   - Navigate away and back
   - Log out and log in
   - Check in different area

3. **Check Debtors List**
   - Go to Payments → Debtors
   - See if customer still listed
   - Note outstanding amount
   - May need approval

4. **Administrator Review**
   - If still not showing
   - Contact admin
   - Provide transaction details
   - Check manual records

---

#### ISSUE: Low Disk Space/Storage Full

**Problem:** System running slow or storage warnings

**Solutions:**
1. **Archive Old Records**
   - Delete completed jobs (optional)
   - Archive old backup files
   - Remove old images
   - Compress old data

2. **Clean System**
   - Clear browser cache
   - Delete temporary files
   - Remove unused images
   - Backup and delete old backups

3. **Upgrade Storage**
   - Contact cloud provider
   - Increase storage limit
   - Or upgrade to larger plan
   - Verify improvement

---

#### ISSUE: Inventory Discrepancies

**Problem:** System quantity doesn't match physical count

**Solutions:**
1. **Investigate Causes**
   - Unrecorded part usage
   - Damaged parts written off
   - Theft or loss
   - Data entry errors
   - System glitch

2. **Check Job Records**
   - Review recent jobs
   - Verify parts recorded correctly
   - Check for duplicate entries
   - Confirm deductions accurate

3. **Physical Verification**
   - Recount items
   - Verify serial numbers
   - Check storage locations
   - Ask team members

4. **Adjust if Needed**
   - If variance confirmed
   - Edit inventory quantity
   - Add adjustment note
   - Record reason
   - Generate adjustment report

---

### Getting Help

**Support Resources:**
1. **In-App Help**
   - Click "Help" link
   - View FAQs
   - Browse documentation
   - Search knowledge base

2. **Administrator**
   - Email: admin@autoserve.com.ng
   - Phone: [Contact Number]
   - Available: Business hours
   - Response: Within 24 hours

3. **Technical Support**
   - Email support tickets
   - Live chat (if available)
   - Video call support
   - Remote assistance

4. **Documentation**
   - User manuals
   - Video tutorials
   - Knowledge base articles
   - FAQ documents

---

## 7. BEST PRACTICES

### Data Entry Best Practices

✅ **DO:**
- Enter complete information for every record
- Use consistent spelling and formatting
- Enter data immediately after events
- Verify information before saving
- Use dropdowns for categorization
- Keep phone numbers in consistent format

❌ **DON'T:**
- Leave required fields blank
- Use abbreviations inconsistently
- Enter incomplete phone numbers/emails
- Duplicate customer records
- Delete records carelessly
- Mix uppercase and lowercase

### Job Management Best Practices

✅ **DO:**
- Document all customer requests
- Record all parts used
- Note any issues found
- Include technician notes
- Complete jobs fully before marking done
- Generate invoices before customer leaves

❌ **DON'T:**
- Estimate parts instead of recording actual
- Skip diagnosis information
- Forget to record labor charges
- Mark incomplete jobs as done
- Leave invoices ungenerated
- Lose documentation

### Financial Best Practices

✅ **DO:**
- Process payments same day received
- Verify payment amounts
- Reconcile daily
- Keep receipts
- Generate reports monthly
- Archive financial documents

❌ **DON'T:**
- Delay payment recording
- Accept partial information
- Skip reconciliation
- Discard receipts
- Skip monthly reports
- Mix personal and business expenses

### Communication Best Practices

✅ **DO:**
- Confirm customer contact information
- Send timely updates
- Follow up after service
- Use professional language
- Maintain communication records
- Respect customer preferences

❌ **DON'T:**
- Send messages without verification
- Delay customer communication
- Skip follow-ups
- Use unprofessional language
- Lose communication records
- Ignore customer preferences

### Inventory Best Practices

✅ **DO:**
- Count inventory regularly
- Maintain minimum stock levels
- Record usage immediately
- Quality check new stock
- Rotate stock (FIFO)
- Archive old inventory reports

❌ **DON'T:**
- Let stock go to zero
- Delay inventory updates
- Accept damaged goods
- Mix old and new stock
- Forget to check expiry dates
- Lose inventory records

---

## 8. FAQ (FREQUENTLY ASKED QUESTIONS)

### General Questions

**Q: How do I change my password?**
A: Click your name (top right) → "My Profile" → Find "Change Password" section → Enter old password → Enter new password → Click "Update Password"

**Q: Can I access the system from my phone?**
A: Yes! The system is mobile-friendly. Open browser on phone and go to the same URL. Most functions work on mobile, though some are easier on desktop.

**Q: How often is data backed up?**
A: Automatic backups occur daily. You can also create manual backups anytime through Settings → Backup.

**Q: What if I accidentally delete a record?**
A: Contact administrator to restore from backup. Keep recent backups on hand for quick recovery.

**Q: Can multiple people work on the same job?**
A: Yes! Multiple users can view job. Last save wins if editing simultaneously. Communicate with team to avoid conflicts.

---

### Customer Management Questions

**Q: How do I find a customer I added last week?**
A: Use search bar at top of page. Type customer name, organization, or customer ID. Or go to Customers → All Customers and browse/filter list.

**Q: Can I merge duplicate customer records?**
A: Yes! Go to Customers → click customer → "Merge Duplicate" option. Select main customer, then customer to merge. System combines records and maintains history.

**Q: How do I see all vehicles for a customer?**
A: Go to Customers → Select Customer → Click "Vehicles Tab" or go to Vehicles → filter by customer.

**Q: Can I update customer information after creating?**
A: Yes! Go to Customers → Select customer → Click "Edit" → Update information → Click "Save".

---

### Job Management Questions

**Q: What's the difference between Invoice, Receipt, and Estimate?**
A: 
- **Invoice:** Billing document showing what was done and amount owed
- **Receipt:** Confirmation of payment received
- **Estimate:** Quote before work begins

**Q: Can I change a job number?**
A: No, job numbers are auto-generated and cannot be changed. They're for system identification.

**Q: How do I add photos to a job?**
A: In job details, find "Gallery" or "Photos" section. Click "Add Images" → Select files from computer → Upload → System saves them.

**Q: What if customer wants different invoice date?**
A: Go to job → Click "Change Invoice Date" → Select new date → Save. System updates invoice date.

**Q: Can I see job history for a specific vehicle?**
A: Yes! Go to Vehicles → Select vehicle → Click "Job History" or go to Jobs → Filter by vehicle.

---

### Payment Questions

**Q: What payment methods can I record?**
A: Cash, Cheque, Bank Transfer, Card, or Other. Select method when recording payment.

**Q: How do I know if a customer still owes money?**
A: Go to Payments → Debtors. Shows all customers with outstanding invoices and amounts owed.

**Q: Can I record partial payments?**
A: Yes! Enter actual amount received. System calculates remaining balance. Can receive multiple partial payments until fully paid.

**Q: How do I generate a payment receipt?**
A: System automatically creates receipt when payment recorded. Go to Payments → Find payment → Click "Print Receipt".

---

### Inventory Questions

**Q: How do I know when to reorder parts?**
A: Go to Inventory → Parts. Parts below minimum stock level are highlighted. Check "Reorder Quantity" field for how many to order.

**Q: What happens to inventory when I use parts in a job?**
A: Automatically deducted! When you record parts in job, system reduces inventory. No separate action needed.

**Q: How do I add parts to inventory?**
A: Go to Sales/Inventory → Parts → Click "Add Part" → Enter part info → Set quantity → Click "Save".

**Q: Can I track parts supplier?**
A: Yes! In part details, you can record preferred supplier and order information.

---

### Reporting Questions

**Q: How often should I generate reports?**
A: Recommend daily revenue check, weekly inventory check, and monthly comprehensive reports. As needed for specific analysis.

**Q: Can I filter reports by date?**
A: Yes! Most reports have date range filters. Select start and end dates before generating.

**Q: Can I export reports to Excel?**
A: Yes! Most reports have "Export to Excel" button. Downloads as .xlsx file.

**Q: How do I see profit for specific period?**
A: Go to Reports → Financial → Profit & Loss. Select date range. Shows income minus expenses.

---

### Technical Questions

**Q: What browsers work with AutoServe?**
A: Chrome, Firefox, Safari, and Edge all work. Recommend latest version of any browser.

**Q: Can I print documents from the system?**
A: Yes! Most documents have "Print" button. Sends to browser print dialog. Can print or save as PDF.

**Q: Is my data secure?**
A: Yes! All data encrypted, regular backups, secure logins, and role-based permissions protect data.

**Q: What should I do if system is slow?**
A: 1) Check internet connection 2) Clear browser cache 3) Try different browser 4) Contact admin if persists

**Q: Can I access system offline?**
A: No, AutoServe requires internet connection. Work offline not supported currently.

---

## QUICK REFERENCE GUIDE

### Common Key Paths

```
CUSTOMER OPERATIONS
├─ Add Customer: Customers → Add New Customer
├─ Search Customer: Use top search bar
├─ View History: Customers → Select → History
└─ Edit Info: Customers → Select → Edit

JOB OPERATIONS
├─ New Job: Jobs → New Job
├─ View Job: Jobs → Pending/Completed → Select
├─ Edit Job: Jobs → Select → Edit
├─ Print Invoice: Jobs → Select → Print
└─ Complete Job: Jobs → Select → Mark Complete

PAYMENTS
├─ Record Payment: Payments → New Payment
├─ View Debtors: Payments → Debtors
├─ Transaction: Payments → Transactions
└─ Receipt: Payments → Select → Print Receipt

INVENTORY
├─ Add Part: Sales/Inventory → Parts → Add Part
├─ View Stock: Sales/Inventory → Parts
├─ Update Quantity: Sales/Inventory → Parts → Edit
└─ Reports: Reports → Inventory

STAFF
├─ Add User: Settings → Users → Add User
├─ Edit User: Settings → Users → Edit
├─ Set Role: Settings → Users → Select Role
└─ Attendance: Job Controls → Attendance
```

### Keyboard Shortcuts

| Shortcut | Action |
|----------|--------|
| F5 | Refresh page |
| Ctrl+P | Print |
| Ctrl+S | Save (where available) |
| Enter | Submit form |
| Tab | Move to next field |
| Esc | Close popup/modal |

### Contact Information

**Technical Support:**
📧 support@autoserve.com.ng
📞 [Support Phone]
🕐 Business Hours: 9 AM - 5 PM

**Sales & Inquiries:**
📧 sales@autoserve.com.ng
🌐 www.autoserve.com.ng

---

## CONCLUSION

AutoServe ERP is designed to be intuitive and user-friendly. This guide provides comprehensive step-by-step procedures for all common tasks. 

**Key Takeaways:**
✅ All features are accessible through clear navigation
✅ Most tasks follow similar workflows
✅ Data is secure with automatic backups
✅ Help is available for any issues
✅ System improves with consistent use

**Start with basics, then explore advanced features as you become comfortable with the system.**

---

*Last Updated: June 2026*
*Version: 1.0*
*For Updates & Support: support@autoserve.com.ng*
