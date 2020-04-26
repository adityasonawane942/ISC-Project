import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { MatTableDataSource } from '@angular/material';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  title = 'iscthtry';
  displayedColumns = ['roll','name', '_id'];
  temp;

  dataSource = new MatTableDataSource(ELEMENT_DATA)

  constructor(
    private http: HttpClient,
  ) { }

  ngOnInit() {
    this.http.get('https://myladder.app/api/assignment/tech')
      .subscribe(
        data => {
          this.temp = data
          for (let i of this.temp) {
            ELEMENT_DATA.push({name: i.name, roll: i.roll, _id: i._id})
            this.dataSource = new MatTableDataSource(ELEMENT_DATA)
          }
        },
        error => {
          alert(JSON.stringify(error))
        },
        () => {}
        )
  }

}

export interface PersonElement {
  name: string;
  roll: number;
  _id: string;
}

const ELEMENT_DATA: PersonElement[] = [];