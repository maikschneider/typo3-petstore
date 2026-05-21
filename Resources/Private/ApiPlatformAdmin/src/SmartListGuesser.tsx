import { Introspecter, ListGuesser } from "@api-platform/admin";
import type { Field } from "@api-platform/api-doc-parser";
import { useResourceContext } from "react-admin";
import { SmartFieldGuesser } from "./SmartFieldGuesser";

interface IntrospectedProps {
  readableFields: Field[];
  [key: string]: unknown;
}

/**
 * Renders one SmartFieldGuesser per readable field of the resource.
 */
const IntrospectedSmartList = ({ readableFields, ...props }: IntrospectedProps) => (
  <ListGuesser {...props}>
    {readableFields.map((field) => (
      <SmartFieldGuesser key={field.name} source={field.name} />
    ))}
  </ListGuesser>
);

/**
 * Auto-discovers all readable fields via the Hydra documentation.
 * No field names are hardcoded.
 */
export const SmartListGuesser = (props: Record<string, unknown>) => {
  const resource = useResourceContext(props as { resource?: string });
  return (
    <Introspecter
      component={IntrospectedSmartList}
      resource={resource!}
      includeDeprecated={true}
      {...props}
    />
  );
};
