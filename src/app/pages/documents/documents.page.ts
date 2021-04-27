import { Component, OnInit } from '@angular/core';
import { DataService } from '../../services/data.service';
import { GlobalVar } from '../../services/GlobalVar';

@Component({
  selector: 'app-documents',
  templateUrl: './documents.page.html',
  styleUrls: ['./documents.page.scss'],
})
export class DocumentsPage implements OnInit {

  documents: Document[] = [];

  constructor( private dataService: DataService,
               private global: GlobalVar) { }

  ngOnInit() {
    this.loadDocs();
  }

  loadDocs() {
    this.dataService.getDocs( this.global ).subscribe( resp => {
      this.documents = resp;
    });
  }
}
