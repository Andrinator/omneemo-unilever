const linkIds = [];
const linkRelations = new SimpleRecord('c_link');
linkRelations.addQuery('type', 'architecture_doc');
linkRelations.selectAttributes('sys_id');
linkRelations.query();

while (linkRelations.next()) {
	linkIds.push(linkRelations.getValue('sys_id'));
}

current.addQuery('sys_id', 'IN', linkIds);
