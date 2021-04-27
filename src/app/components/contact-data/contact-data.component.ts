import { Component, Input, OnInit } from '@angular/core';
import { User } from 'src/app/interfaces/interface';

@Component({
  selector: 'app-contact-data',
  templateUrl: './contact-data.component.html',
  styleUrls: ['./contact-data.component.scss'],
})
export class ContactDataComponent implements OnInit {

  @Input() users: User[];
  
  constructor() { }

  ngOnInit() {}

}
