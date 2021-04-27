import { Component, Input, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { ModalController } from '@ionic/angular';
import { GlobalVar } from 'src/app/services/GlobalVar';
import { User } from '../../interfaces/interface';
import { DataService } from '../../services/data.service';

@Component({
  selector: 'app-edit-profile',
  templateUrl: './edit-profile.page.html',
  styleUrls: ['./edit-profile.page.scss'],
})
export class EditProfilePage implements OnInit {

  @Input() users = {
    address: '',
    village: '',
    postalCode: '',
    user1: '',
    phone1: '',
    email1: ''
  }

  @Input() user2: User;
  
  constructor( private modalController: ModalController, 
               private dataService: DataService, 
               private global: GlobalVar ) {
    this.user2 = new User();
  }

  ngOnInit() {
    this.loadUser();
  }
  
  acceptChanges( form: NgForm ) {
    this.modalController.dismiss({
      users: this.users
    });
  }

  loadUser() {
    this.dataService.getUser( this.global ).subscribe( resp => {
      this.user2 = resp[0];
    });
  }
}