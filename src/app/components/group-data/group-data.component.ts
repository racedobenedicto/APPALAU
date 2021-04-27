import { Component, Input, OnInit } from '@angular/core';
import { Profile } from '../../interfaces/interface';

@Component({
  selector: 'app-group-data',
  templateUrl: './group-data.component.html',
  styleUrls: ['./group-data.component.scss'],
})
export class GroupDataComponent implements OnInit {

  @Input() profile: Profile = new Profile();
  
  constructor() { }

  ngOnInit() {}

}
