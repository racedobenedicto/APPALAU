import { Component, Input, OnInit } from '@angular/core';
import { Profile } from 'src/app/interfaces/interface';

@Component({
  selector: 'app-personal-data',
  templateUrl: './personal-data.component.html',
  styleUrls: ['./personal-data.component.scss'],
})
export class PersonalDataComponent implements OnInit {

  @Input() profile: Profile = new Profile();
  
  constructor() { }

  ngOnInit() {}

}
