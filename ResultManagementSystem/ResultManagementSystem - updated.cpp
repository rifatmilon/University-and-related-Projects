#include <iostream>
#include <iomanip>
#include <string>
using namespace std;

class SR {    //SR = Students' Result/Record;
public:
    string Name;
    string Dept;    //Dept = Department;
    int ID;
    string LG;    //LG = Letter Grade;
    double CGPA;
    SR* next;
};

void CoverPage();    //Out of context!
void Print(SR* head);
void CongratsOrSorry(SR* temp);
void printASingleNode(SR* flag);
void IndlRsltBN(SR* head);
void IndlRsltBID(SR* head);
void NSI(string* Name, string* Dept, int* ID, string* LG, double* CGPA);
void insertAtTheFront(SR** head, string Name, string Dept, int ID, string LG, double CGPA);
void insertAfter(SR** head, int PRID);
void insertAtTheEnd(SR** head, string Name, string Dept, int ID, string LG, double CGPA);
void updateARrecord(SR** head, int ID);
void deleteR(SR** head_ref, int ID);
void MergeSort(SR** head, int opn);
void splitter(SR* source, SR** frontRef, SR** backRef);
SR* SortedMergeBID(SR* a, SR* b);
SR* SortedMergeBCGPA(SR* a, SR* b);

int main()
{
    CoverPage();    //Out of context!

    SR* FirstStudent = new SR();    //Head pointer of the list;
    FirstStudent = NULL;

    //Initial manual records to demonstrate;
    insertAtTheEnd(&FirstStudent, "Rifat Aknda", "CSE", 221, "A", 4.00);
    insertAtTheEnd(&FirstStudent, "Rina Akter", "BBA", 222, "B-", 2.89);
    insertAtTheEnd(&FirstStudent, "Rakib Ahmed", "EEE", 223, "C", 2.20);
    insertAtTheEnd(&FirstStudent, "Lisa Rahman", "MSJ", 224, "B", 3.05);
    insertAtTheEnd(&FirstStudent, "Faisal Sarker", "ETE", 225, "A-", 3.88);
    insertAtTheEnd(&FirstStudent, "Abdullah Nur Faisal", "CSE", 226, "B+", 3.39);
    insertAtTheEnd(&FirstStudent, "Sonali Sultana", "ETE", 227, "D", 1.50);
    insertAtTheEnd(&FirstStudent, "Roma Akter", "BBA", 228, "B", 3.10);
    insertAtTheEnd(&FirstStudent, "Rimo Rahman", "CSE", 229, "F", 0.00);
    insertAtTheEnd(&FirstStudent, "Sonia Sultana", "CSE", 231, "A", 4.00);
    insertAtTheEnd(&FirstStudent, "Rina Akter", "CSE", 232, "C+", 2.67);

    while (true) {
        cout << endl << endl << "                                                     *Dashboard*" << endl << endl;

        int option, password, studentPassword = 1916, adminPassword = 1160;
        cout << "Please select an option:" << endl;
        cout << "   1. Student Login" << endl;
        cout << "   2. Admin Login" << endl;
        cout << "   3. EXIT " << endl << endl;
        cin >> option; 
        cout << endl;

        if (option == 1) {
            cout << "Please Enter your password: ";
            cin >> password;
            cout << endl;
            if (password == studentPassword) {
                int op;    //op = option;
                cout << "Please select an option:" << endl;
                cout << "   1. Search Result by Name" << endl << "   2. Search Result by ID" << endl << endl;
                cin >> op;
                cout << endl;
                if (op == 1) {
                    IndlRsltBN(FirstStudent);
                }
                else if (op == 2) {
                    IndlRsltBID(FirstStudent);
                }
                else {
                    cout << "Wrong option! Please try again later." << endl;
                }
            }
            else {
                cout << "Wrong password, Please try again later." << endl;
            }
        }
        else if (option == 2) {
            cout << "Please Enter your password: ";
            cin >> password;
            cout << endl;
            if (password == adminPassword) {
                int opt;
                cout << "Please select an option:" << endl;
                cout << "   1. View Results List" << endl << "   2. Update Results List" << endl << endl;
                cin >> opt;    //opt = option;
                cout << endl;
                if (opt == 1) {
                    cout << "Please select an option:" << endl;
                    cout << "   1. Results List" << endl << "   2. Results List Based on ID Number" << endl;
                    cout << "   3. Results List Based on CGPA" << endl << endl;
                    int opn;    //opn = option;
                    cin >> opn;
                    cout << endl;
                    if (opn == 1) {
                        cout << "Results list" << endl; 
                        Print(FirstStudent);
                    }
                    else if (opn == 2) {
                        cout << "Results list based on ID number" << endl; 
                        MergeSort(&FirstStudent, opn);
                        Print(FirstStudent);
                    }
                    else if (opn == 3) {
                        cout << "Results list based on CGPA" << endl;
                        MergeSort(&FirstStudent, opn);
                        Print(FirstStudent);
                    }
                    else {
                        cout << "Wrong option! Please try again later." << endl;
                    }
                }
                else if (opt == 2) {
                    cout << "Please select an option: " << endl;
                    cout << "   1. Add a new result" << endl << "   2. Update an old result" << endl << "   3. Delete an old result" << endl << endl;
                    int optn, ID;    //optn = option;
                    cin >> optn;
                    cout << endl;
                    if (optn == 1) {
                        int optin, ID;    //optin = option;
                        string Name, Dept, LG;
                        double CGPA;
                        cout << "Please select an option: " << endl;
                        cout << "   1. Add a new result first to the list" << endl;
                        cout << "   2. Add a new result in the middle of the list" << endl;
                        cout << "   3. Add a new result at the end of the list" << endl << endl;
                        cin >> optin;
                        if (optin == 1) { 
                            cout << endl;
                            NSI(&Name, &Dept, &ID, &LG, &CGPA);
                            insertAtTheFront(&FirstStudent, Name, Dept, ID, LG, CGPA);
                            cout << endl << "inserted successfully!" << endl;
                        }
                        else if (optin == 2) {
                            cout << endl;
                            cout << "Previous record's ID: ";
                            int prid;    //prid = previous record's id;
                            cin >> prid;
                            cout << endl;
                            insertAfter(&FirstStudent, prid);
                        } 
                        else if (optin == 3) {
                            cout << endl;
                            NSI(&Name, &Dept, &ID, &LG, &CGPA);
                            insertAtTheEnd(&FirstStudent, Name, Dept, ID, LG, CGPA);
                            cout << endl << "inserted successfully!" << endl;
                        }
                        else {
                            cout << "Wrong option! Please try again later." << endl;
                        }
                    }
                    else if (optn == 2) {
                        cout << "Please enter the ID number: ";
                        cin >> ID;
                        cout << endl;
                        updateARrecord(&FirstStudent, ID); 
                    }
                    else if (optn == 3) {
                        cout << "Please enter the ID number: ";
                        cin >> ID;
                        deleteR(&FirstStudent, ID);
                        cout << endl << "deleted successfully!" << endl;
                    }
                    else {
                        cout << "Wrong option! Please try again later." << endl;
                    }
                }
                else {
                    cout << "Wrong option! Please try again later." << endl;
                }
            }
            else {
                cout << "Wrong Password, Please try again later." << endl;
            }
        }
        else if (option == 3) {
            break;
        }
    }
    
    cout << "Thanks for using RMS!" << endl;    //RMS = Result Management System;

    system("pause>0");
    return 0;
}

void Print(SR* head) {
    SR* temp = new SR();    //temp = temporary;
    temp = head;
    cout << endl;

    while (temp != NULL) {
        cout << "Name: " << temp->Name << endl;
        cout << "Dept: " << temp->Dept << endl;
        cout << "ID: " << temp->ID << endl;
        cout << "Letter Grade: " << temp->LG << endl;
        cout << "CGPA: " << setprecision(2) << fixed << temp->CGPA << endl << endl;
        temp = temp->next;
    }
}

void CongratsOrSorry(SR* temp) {
    if (temp->CGPA > 0.00) {
        cout << "Congrats " << temp->Name << "! You've successfully passed the exams!" << endl << "Your result details is: " << endl;
    }
    else {
        cout << "Sorry " << temp->Name << "! You've failed!" << endl << "Your result details is: " << endl;
    }
}

void printASingleNode(SR* temp) {
    cout << "Name: " << temp->Name << endl;
    cout << "Dept: " << temp->Dept << endl;
    cout << "ID: " << temp->ID << endl;
    cout << "Letter Grade: " << temp->LG << endl;
    cout << "CGPA: " << setprecision(2) << fixed << temp->CGPA << endl << endl;
}

void IndlRsltBN(SR* head) {
    SR* temp = head;
    SR* dtemp = head;
    SR* flag = new SR();
    int count = 0;
    string name;
    cout << "Enter your Name: ";
    cin.ignore();
    getline(cin, name);
    cout << endl;
    
    while (temp != NULL) {
        if (name == temp->Name) {
            count++;
        }
        temp = temp->next;
    }

    if (count == 1) {
        while (dtemp != NULL) {
            if (name == dtemp->Name) {
                flag = dtemp;
                CongratsOrSorry(flag);
                printASingleNode(flag);
            }
            dtemp = dtemp->next;
        }
    }
    else if (count > 1) {
        int id;
        cout << "Enter your ID: ";
        cin >> id;
        bool fort = false;    //fort = for true
        cout << endl;
        while (dtemp != NULL) {
            if (name == dtemp->Name && id == dtemp->ID) {
                flag = dtemp;
                CongratsOrSorry(flag);
                printASingleNode(flag);
                fort = true;
            }
            dtemp = dtemp->next;
        }
        if (fort == false) {
            cout << "Name and ID didn't matched! Please try again later!" << endl;
        }
    }
    else {
        cout << "Sorry, " << name << endl << "Results not found." << endl << endl;
    }
}

void IndlRsltBID(SR* head) {
    SR* temp = head;
    SR* flag = new SR();
    int id;
    bool fort = false; 
    cout << "Enter your ID: ";
    cin >> id;
    cout << endl;

    while (temp != NULL) {
        if (id == temp->ID) {
            flag = temp;
            CongratsOrSorry(flag);
            printASingleNode(flag);
            fort = true;
            break;
        }
        temp = temp->next;
    }

    if (fort == false) {
        cout << "Sorry!" << endl << "Results not found." << endl << endl;
    }
}

void NSI(string* Name, string* Dept, int* ID, string* LG, double* CGPA) {
    cout << "Please enter the new student's information: " << endl;
    cout << "Name: ";
    cin.ignore();
    getline(cin, *Name);
    cout << "Department: ";
    getline(cin, *Dept);
    cout << "ID: ";
    cin >> *ID;
    cout << "Letter Grade: ";
    cin.ignore();
    getline(cin, *LG);
    cout << "CGPA: ";
    cin >> *CGPA;
}

void insertAtTheFront(SR** head, string Name, string Dept, int ID, string LG, double CGPA) {
    SR* newRecord = new SR();
    newRecord->Name = Name;
    newRecord->Dept = Dept;
    newRecord->ID = ID;
    newRecord->LG = LG;
    newRecord->CGPA = CGPA;
    newRecord->next = *head;
    *head = newRecord;
}

void insertAfter(SR** head, int PRID) { 
    SR* precord = *head;
    bool fort = false;
    string Name, Dept, LG;
    int ID;
    double CGPA;

    if (precord == NULL) {
        cout << "Previous Record can not be the last record" << endl;
        return;
    }

    NSI(&Name, &Dept, &ID, &LG, &CGPA);

    while (precord != NULL) {
        if (precord->ID == PRID) {
            SR* newRecord = new SR();
            newRecord->Name = Name;
            newRecord->Dept = Dept;
            newRecord->ID = ID;
            newRecord->LG = LG;
            newRecord->CGPA = CGPA;
            newRecord->next = precord->next;
            precord->next = newRecord;
            fort = true;
            cout << endl << "inserted successfully!" << endl;
            break;
        }
        precord = precord->next;
    }

    if (fort == false) {
        cout << "There's no ID like the one you entered!" << endl;
    }
}

void insertAtTheEnd(SR** head, string Name, string Dept, int ID, string LG, double CGPA) {
    SR* newRecord = new SR();
    SR* last = *head;
    newRecord->Name = Name;
    newRecord->Dept = Dept;
    newRecord->ID = ID;
    newRecord->LG = LG;
    newRecord->CGPA = CGPA;
    newRecord->next = NULL;

    if (*head == NULL) { //if the list is empty;
        *head = newRecord;
        return;
    }
    
    while (last->next != NULL) {
        last = last->next;
    }

    last->next = newRecord;
}

void updateARrecord(SR** head, int ID) {
    SR* temp = *head;
    string Name, Dept, LG;
    double CGPA;
    bool fort = false;

    while (temp != NULL) {
        if (temp->ID == ID) {
            cout << "Please enter the updated information: " << endl;
            cout << "Name: ";
            cin.ignore();
            getline(cin, Name);
            cout << "Department: ";
            getline(cin, Dept);
            cout << "Letter Grade: ";
            getline(cin, LG);
            cout << "CGPA: ";
            cin >> CGPA;
            temp->Name = Name;
            temp->Dept = Dept;
            temp->LG = LG;
            temp->CGPA = CGPA;
            fort = true;
            cout << endl << "updated successfully!" << endl;
            break;
        }
        temp = temp->next;
    }

    if (fort == false) {
        cout << "There's no ID like the one you entered!" << endl;
    }
}

void deleteR(SR** head, int ID) {
    SR* temp = *head;
    SR* prev = NULL;    //prev = previous;

    if (temp != NULL && temp->ID == ID) {    //if the first record to be delated;
        *head = temp->next;
        delete temp;    // Free memory
        return;
    }
    else {
        while (temp != NULL && temp->ID != ID) {
            prev = temp;
            temp = temp->next;
        }
        if (temp == NULL) return;
        prev->next = temp->next;
        delete temp; 
    }
}
