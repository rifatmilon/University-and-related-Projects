#include <iostream>
#include <iomanip>
#include <string>
using namespace std;

class SR {
public:
    string Name;
    string Dept;
    int ID;
    string LG;
    double GPA;
    SR* next;
};

void CoverPage(); //Out of context!
void Print(SR* head);
void CongratsOrSorry(SR* temp);
void printASingleNode(SR* flag);
void IndlRsltBN(SR* head);
void IndlRsltBID(SR* head);
void NSI(string* Name, string* Dept, int* ID, string* LG, double* GPA);
void insertAtTheEnd(SR** head, string Name, string Dept, int ID, string LG, double GPA);
void updateARrecord(SR** head, int ID);
void deleteR(SR** head_ref, int ID);
void MergeSort(SR** headRef);
void splitter(SR* source, SR** frontRef, SR** backRef);
SR* SortedMerge(SR* a, SR* b);

int main()
{
    CoverPage(); //Out of context!

    SR* FirstStudent = new SR();//Head pointer of the list;
    FirstStudent = NULL;

    insertAtTheEnd(&FirstStudent, "Rifat", "CSE", 221, "B+", 3.55);
    insertAtTheEnd(&FirstStudent, "Rina", "BBA", 222, "B-", 2.89);
    insertAtTheEnd(&FirstStudent, "Rakib", "EEE", 223, "C", 2.20);
    insertAtTheEnd(&FirstStudent, "Lisa", "MSJ", 224, "B", 3.05);
    insertAtTheEnd(&FirstStudent, "Faisal", "ETE", 225, "A-", 3.88);
    insertAtTheEnd(&FirstStudent, "Abdullah", "CSE", 226, "B+", 3.39);
    insertAtTheEnd(&FirstStudent, "Sonali", "ETE", 227, "D", 1.50);
    insertAtTheEnd(&FirstStudent, "Roma", "BBA", 228, "B", 3.10);
    insertAtTheEnd(&FirstStudent, "Rimo", "CSE", 229, "F", 0.00);
    insertAtTheEnd(&FirstStudent, "Sonia", "MSJ", 230, "A", 4.00);
    insertAtTheEnd(&FirstStudent, "Rina", "CSE", 231, "C+", 2.67);

    while (true) {
        cout << endl << endl << "                                                     *Dashboard*" << endl << endl;

        int option, password, studentPassword = 309, adminPassword = 916;
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
                int op;
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
                cin >> opt;
                cout << endl;
                if (opt == 1) {
                    cout << "Please select an option:" << endl;
                    cout << "   1. Results List Based on ID Number" << endl << "   2. Results List Based on GPA" << endl << endl;
                    int opn;
                    cin >> opn;
                    cout << endl;
                    if (opn == 1) {
                        cout << "Results list based on ID number" << endl;
                        Print(FirstStudent);
                    }
                    else if (opn == 2) {
                        cout << "Results list based on GPA" << endl;
                        MergeSort(&FirstStudent);
                        Print(FirstStudent);
                    }
                    else {
                        cout << "Wrong option! Please try again later." << endl;
                    }
                }
                else if (opt == 2) {
                    cout << "Please select an option: " << endl;
                    cout << "   1. Add a new result" << endl << "   2. Update an old result" << endl << "   3. Delete an old result" << endl << endl;
                    int optn, ID;
                    cin >> optn;
                    cout << endl;
                    if (optn == 1) {
                        string Name, Dept, LG;
                        double GPA;
                        NSI(&Name, &Dept, &ID, &LG, &GPA);
                        insertAtTheEnd(&FirstStudent, Name, Dept, ID, LG, GPA);
                        cout << endl << "inserted successfully!" << endl;
                    }
                    else if (optn == 2) {
                        cout << "Please enter the ID number: ";
                        cin >> ID;
                        cout << endl;
                        updateARrecord(&FirstStudent, ID);
                        cout << endl << "updated successfully!" << endl;
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
    
    cout << "Thanks for using RMS!" << endl; //RMS = Result Management System;
    system("pause>0");
}

void Print(SR* head) {
    SR* temp = new SR();
    temp = head;
    cout << endl;

    while (temp != NULL) {
        cout << "Name: " << temp->Name << endl;
        cout << "Dept: " << temp->Dept << endl;
        cout << "ID: " << temp->ID << endl;
        cout << "Latter Grade: " << temp->LG << endl;
        cout << "GPA: " << setprecision(2) << fixed << temp->GPA << endl << endl;
        temp = temp->next;
    }
}

void CongratsOrSorry(SR* temp) {
    if (temp->GPA > 0.00) {
        cout << "Congrats " << temp->Name << "!, You've successfully passed the exams!" << endl << "Your result details is: " << endl;
    }
    else {
        cout << "Sorry " << temp->Name << "!, You've failed!" << endl << "Your result details is: " << endl;
    }
}

void printASingleNode(SR* temp) {
    cout << "Name: " << temp->Name << endl;
    cout << "Dept: " << temp->Dept << endl;
    cout << "ID: " << temp->ID << endl;
    cout << "Latter Grade: " << temp->LG << endl;
    cout << "GPA: " << setprecision(2) << fixed << temp->GPA << endl << endl;
}

void IndlRsltBN(SR* head) {
    SR* temp = head;
    SR* dtemp = head;
    SR* flag = new SR();
    int count = 0;
    string name;
    cout << "Enter your Name: ";
    cin >> name;
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
        bool fort = false; //fort = for true
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
    bool fort = false; //fort = for true;
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

void NSI(string* Name, string* Dept, int* ID, string* LG, double* GPA) {
    cout << "Please enter the new student's information: " << endl;
    cout << "Name: ";
    cin >> *Name;
    cout << "Department: ";
    cin >> *Dept;
    cout << "ID: ";
    cin >> *ID;
    cout << "Latter Grade: ";
    cin >> *LG;
    cout << "GPA: ";
    cin >> *GPA;
}

void insertAtTheEnd(SR** head, string Name, string Dept, int ID, string LG, double GPA) {
    SR* newRecord = new SR();
    SR* last = *head;
    newRecord->Name = Name;
    newRecord->Dept = Dept;
    newRecord->ID = ID;
    newRecord->LG = LG;
    newRecord->GPA = GPA;
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
    double GPA;
    cout << "Please enter the updated information: " << endl;
    cout << "Name: "; 
    cin >> Name; 
    cout << "Department: "; 
    cin >> Dept;
    cout << "Latter Grade: "; 
    cin >> LG; 
    cout << "GPA: "; 
    cin >> GPA;

    while (temp != NULL) {
        if (temp->ID == ID) {
            temp->Name = Name;
            temp->Dept = Dept;
            temp->LG = LG;
            temp->GPA = GPA;
        }
        temp = temp->next;
    }
}

void deleteR(SR** head, int ID) {
    SR* temp = *head;
    SR* prev = NULL;

    if (temp != NULL && temp->ID == ID) //if the first record to be delated;
    {
        *head = temp->next;
        delete temp; // Free memory
        return;
    }
    else
    {
        while (temp != NULL && temp->ID != ID)
        {
            prev = temp;
            temp = temp->next;
        }
        if (temp == NULL) return;
        prev->next = temp->next;
        delete temp; // Free memory
    }
}

void MergeSort(SR** head) {
    SR* temphead = *head;
    SR* a, * b;

    if ((temphead == NULL) || (temphead->next == NULL)) return;

    splitter(temphead, &a, &b);

    MergeSort(&a);
    MergeSort(&b);

    *head = SortedMerge(a, b);
}

void splitter(SR* temp, SR** front, SR** back) {
    SR* fast;
    SR* slow;
    slow = temp;
    fast = temp->next;

    while (fast != NULL) {
        fast = fast->next;
        if (fast != NULL) {
            slow = slow->next;
            fast = fast->next;
        }
    }

    *front = temp;
    *back = slow->next;
    slow->next = NULL;
}

SR* SortedMerge(SR* a, SR* b) {
    SR* temp = new SR();
    temp->GPA = 0;
    temp->next = NULL;
    SR* last = temp;

    while (a != NULL && b != NULL) {
        if (a->GPA > b->GPA) {
            last->next = a;
            a = a->next;
            last = last->next;
        }
        else {
            last->next = b;
            b = b->next;
            last = last->next;
        }
    }

    if (a != NULL) {
        last->next = a;
    }

    if (b != NULL) {
        last->next = b;
    }

    return temp->next;
}
//------------------------------------------------------------THE END--------------------------------------------------------------

void CoverPage() {
    cout << "Final Project" << endl;
    cout << "Course Code: CSE 1302" << endl;
    cout << "Course Title: Data Structure Lab" << endl << endl;
    cout << "Submitted by:" << endl;
    cout << "Name: Md. Rifat Aknda" << endl;
    cout << "ID: 212014003" << endl << endl;
    cout << "Submitted to:" << endl;
    cout << "Niaz Ashraf Khan" << endl; 
    cout << "Lecturer" << endl;
    cout << "Department of Computer Science and Engineering" << endl;
    cout << "University of Liberal Arts Bangladesh" << endl << endl << endl;
}

/*
void ReadInformation() {
    getline(cin, Name);
    cin >> Age;
    cin.ignore();
    //getchar();
    getline(cin, FaceColor);
    getline(cin, EyeColor);
}
*/